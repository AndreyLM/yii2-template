<?php

namespace backend\controllers;

use domain\entities\menu\Item;
use domain\exceptions\DomainException;
use domain\formaters\ArrayListMenuItemsFormatter;
use domain\services\IMenuService;
use domain\services\MenuService;
use Yii;
use yii\base\Module;
use yii\web\Controller;
use yii\filters\VerbFilter;

/**
 * MenuController implements the CRUD actions for Menu model.
 */
class MenuItemController extends BaseController
{
    private $menuService;

    public function __construct($id, Module $module, IMenuService $menuService, array $config = [])
    {
        $this->menuService = $menuService;

        parent::__construct($id, $module, $config);
    }


    /**
     * Lists all Menu models.
     * @param $menuId int
     * @return mixed
     */
    public function actionIndex($menuId)
    {

        $menu = $this->menuService->getFullMenuItems($menuId);
        return $this->render('index.twig',[
           'model' => $menu,

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
            'model' => $this->menuService->getItem($id),
            'isActive' => function(Item $item) {
                return $this->isActive($item);
            },
            'types' => function(Item $item) {
                $types = $item->getItemTypes();
                return $types[$item->type];
            }
        ]);
    }

    /**
     * Creates a new Menu model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @param $menuId int
     * @return mixed
     */
    public function actionCreate($menuId)
    {
        return $this->save($menuId, new Item(), 'create');
    }

    /**
     * Updates an existing Menu model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @param integer $menuId
     * @return mixed
     */
    public function actionUpdate($menuId, $id)
    {
        return $this->save($menuId, $this->menuService->getItem($id), 'update');
    }

    /**
     * Deletes an existing Menu model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @param integer $menuId
     * @return mixed
     */
    public function actionDelete($menuId,$id)
    {
        try {
            $this->menuService->delete($id);
            Yii::$app->session->setFlash('success', 'Menu was successfully deleted');
        } catch (DomainException $exception){
            Yii::$app->session->setFlash('error', $exception->getMessage());
        }

        return $this->redirect(['index', 'menuId' => $menuId]);
    }

    private function save(int $menuId, Item $model, $view = 'create')
    {
        if(!$model->id) {
            $model->menu = $this->menuService->getMenu($menuId);
        }

        if ($model->load(Yii::$app->request->post())) {
            try {
                $id = $this->menuService->saveMenuItem($model);
                Yii::$app->session->setFlash('success',
                    'Item was successfully '.$view.'d');
                return $this->redirect(['view', 'id' => $id]);
            } catch (DomainException $exception) {
                Yii::$app->session->setFlash('error', $exception->getMessage());
            }

        }

        return $this->render($view.'.twig', [
            'model' => $model,
            'list' => $this->menuService->format(new ArrayListMenuItemsFormatter(), $menuId)
        ]);
    }

    private function isActive(Item $item)
    {
        return $item->status ? '<i class="fa fa-check-circle-o fa-1g"></i>' :
            '<i class="fa fa-circle-o fa-1g"></i>';
    }
}
