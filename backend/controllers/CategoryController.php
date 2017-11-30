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
        $this->layout = 'main.twig';

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



        return $this->render('index.twig', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'isActive' => function(\domain\mysql\Category $category) {
                return $this->isActive($category);
            }
        ]);
    }

    /**
     * Displays a single Category model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $isActive = function (Category $category) {
            return $category->status ? '<i class="fa fa-check-circle-o fa-1g"></i>' :
                                        '<i class="fa fa-circle-o fa-1g"></i>';
        };

        return $this->render('view.twig', [
            'model' => $this->categoryService->getOne($id),
            'isActive' => $isActive,
        ]);
    }

    /**
     * Creates a new Category model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        return $this->save(new Category(), new Meta(), 'create');
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

        return $this->save($model, $model->getMeta(), 'update');
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
        $categoriesList = $this->categoryService
            ->format(new ArrayListCategoryFormatter(), $this->categoryService->getAll());

        if($id = $this->load($model, $meta)) {
            \Yii::$app->session->setFlash('success',
                'Category '.$id.' was successfully '.$view.'ed');
            return $this->redirect([
                'view',
                'id' => $id
            ]);
        }

        return $this->render($view.'.twig', [
            'model' => $model,
            'meta' => $meta,
            'list' => $categoriesList
        ]);
    }

    private function load(Category $category, Meta $meta)
    {
        $post = Yii::$app->request->post();
        if( $category->load($post) && $meta->load($post)) {
            $category->setMeta($meta);

          if($id = $this->categoryService->save($category)) {
              return $id;
          }

            \Yii::$app->session->setFlash('error', 'Please enter correct values');
        }

        return false;
    }

    private function isActive(\domain\mysql\Category $category)
    {
            return $category->status ? '<i class="fa fa-check-circle-o fa-1g"></i>' :
                '<i class="fa fa-circle-o fa-1g"></i>';
    }

}
