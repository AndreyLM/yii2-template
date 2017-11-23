<?php

namespace backend\controllers;

use domain\entities\Meta;
use domain\exceptions\DomainException;
use domain\formaters\ArrayListCategoryFormatter;
use domain\services\CategoryService;
use Yii;
use domain\entities\Category;
use domain\mysql\searches\CategorySearch;
use yii\base\Module;
use yii\web\Controller;
use yii\filters\VerbFilter;

/**
 * CategoryController implements the CRUD actions for Category model.
 */
class CategoryController extends Controller
{

    private $categoryService;

    public function __construct($id, Module $module, array $config = [])
    {
        $this->categoryService = new CategoryService();
        parent::__construct($id, $module, $config);
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Category models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CategorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Category model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->categoryService->getOne($id),
        ]);
    }

    /**
     * Creates a new Category model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Category();
        $meta = new Meta();
        return $this->save($model, $meta, 'create');
    }

    /**
     * Updates an existing Category model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->categoryService->getOne($id);
        $meta = $model->getMeta();
        return $this->save($model, $meta, 'update');
    }

    /**
     * Deletes an existing Category model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        try {
                $this->categoryService->delete($id);
                \Yii::$app->session->setFlash('success', 'Category '.$id.' was removed');
        } catch (DomainException $exception) {
                \Yii::$app->session->setFlash('error', $exception->getMessage());
        }

        return $this->redirect(['index']);
    }

    private function save(Category $model, Meta $meta, $view = 'create')
    {

        $categories = $this->categoryService->getAll();
        $categoriesList = $this->categoryService
            ->format(new ArrayListCategoryFormatter(), $categories);

        if($id = $this->load($model, $meta)) {
            \Yii::$app->session->setFlash('success',
                'Category '.$id.' was successfully '.$view.'ed');
            return $this->redirect([
                'view',
                'id' => $id
            ]);
        }

        return $this->render($view, [
            'model' => $model,
            'meta' => $meta,
            'list' => $categoriesList
        ]);
    }

    private function load(Category $category, Meta $meta)
    {
        $post = Yii::$app->request->post();
        if( $category->load($post) && $meta->load($post)) {
            $id = $this->categoryService->save($category);
            if(!$id) {
                \Yii::$app->session->setFlash('error', 'Please enter correct values');
                return false;
            }

            return $id;
        }

        return false;
    }

}
