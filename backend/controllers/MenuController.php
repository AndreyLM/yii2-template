<?php

namespace backend\controllers;

use domain\exceptions\DomainException;
use domain\services\IMenuService;
use domain\services\MenuService;
use Yii;
use domain\entities\menu\Menu;
use domain\mysql\searches\MenuSearch;
use yii\base\Module;
use yii\web\Controller;
use yii\filters\VerbFilter;

/**
 * MenuController implements the CRUD actions for Menu model.
 */
class MenuController extends BaseController
{
    private $menuService;

    public function __construct($id, Module $module, IMenuService $menuService, array $config = [])
    {
        $this->menuService = $menuService;

        parent::__construct($id, $module, $config);
    }


    /**
     * Lists all Menu models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MenuSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index.twig', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Menu model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view.twig', [
            'model' => $this->menuService->getMenu($id),
        ]);
    }

    /**
     * Creates a new Menu model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        return $this->save(new Menu(), 'create');
    }

    /**
     * Updates an existing Menu model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        return $this->save($this->menuService->getMenu($id), 'update');
    }

    /**
     * Deletes an existing Menu model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        try {
            $this->menuService->delete($id);
            Yii::$app->session->setFlash('success', 'Menu was successfully deleted');
        } catch (DomainException $exception){
            Yii::$app->session->setFlash('error', $exception->getMessage());
        }

        return $this->redirect(['index']);
    }

    private function save(Menu $model, $view = 'create')
    {
        if ($model->load(Yii::$app->request->post())) {
            try {
                $id = $this->menuService->saveMenu($model);
                Yii::$app->session->setFlash('success',
                    'Menu was successfully '.$view.'ed');
                return $this->redirect(['view', 'id' => $id]);
            } catch (DomainException $exception) {
                Yii::$app->session->setFlash('error', $exception->getMessage());
            }

        }

        return $this->render($view.'.twig', [
            'model' => $model,
        ]);
    }
}
