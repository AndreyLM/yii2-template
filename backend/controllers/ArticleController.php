<?php

namespace backend\controllers;

use domain\entities\Meta;
use domain\services\CategoryService;
use domain\services\IArticleService;
use DomainException;
use Yii;
use domain\entities\Article;
use domain\mysql\searches\ArticleSearch;
use yii\base\Module;

/**
 * ArticleController implements the CRUD actions for Article model.
 */
class ArticleController extends BaseController
{

    private $articleService;

    public function __construct($id, Module $module, IArticleService $articleService, array $config = [])
    {
        $this->articleService = $articleService;
        parent::__construct($id, $module, $config);
    }

    /**
     * Lists all Article models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ArticleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index.twig', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Article model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $categoryList =  $this->articleService
        ->getCategoryList(new CategoryService());

        return $this->render('view.twig', [
            'model' => $this->articleService->getOne($id),
            'categoryTitle' => function(Article $article) use ($categoryList) {
                return $categoryList[$article->categoryId] ;
            },
            'categoryList' => $categoryList
        ]);
    }

    /**
     * Creates a new Article model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        return $this->save(new Article(), new Meta(), 'create');
    }

    /**
     * Updates an existing Article model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->articleService->getOne($id);

        return $this->save($model, $model->getMeta(), 'update');
    }

    /**
     * Deletes an existing Article model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        try {
            $this->articleService->delete($id);
            \Yii::$app->session->setFlash('success', 'Article '.$id.' was removed');
        } catch (DomainException $exception) {
            \Yii::$app->session->setFlash('error', $exception->getMessage());
        }

        return $this->redirect(['index']);
    }

    private function save(Article $model, Meta $meta, $view = 'create')
    {
        if($id = $this->load($model, $meta)) {
            \Yii::$app->session->setFlash('success',
                'Article '.$id.' was successfully '.$view.'ed');

            return $this->redirect([
                'view',
                'id' => $id
            ]);
        }

        $categoryList = $this->articleService->getCategoryList(new CategoryService());
        return $this->render($view.'.twig', [
            'model' => $model,
            'meta' => $meta,
            'categories' => $categoryList,
        ]);
    }

    private function load(Article $article, Meta $meta)
    {
        $post = Yii::$app->request->post();

        if($article->load($post) && $meta->load($post)) {
            $article->setMeta($meta);

            if($id = $this->articleService->save($article)) {
                return $id;
            }

            \Yii::$app->session->setFlash('error', 'Please enter correct values');
        }

        return false;
    }
}
