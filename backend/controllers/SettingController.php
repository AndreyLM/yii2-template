<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 12/20/17
 * Time: 8:39 AM
 */

namespace backend\controllers;


use domain\exceptions\DomainException;
use domain\services\ConfigService;
use domain\services\IMenuService;
use Yii;
use yii\base\Model;
use yii\base\Module;

class SettingController extends BaseController
{
    private $configService;

    public function __construct($id, Module $module, IMenuService $menuService, array $config = [])
    {
        $this->configService = new ConfigService($menuService);
        parent::__construct($id, $module, $config);
    }

    public function actionIndex()
    {
        /* @var $settings \domain\entities\Setting[] */
        $settings = $this->configService->getAll();

        if (Model::loadMultiple($settings, Yii::$app->request->post())) {
            try {
                $this->configService->save($settings);
                Yii::$app->session->setFlash('success', 'All settings were saved');
            } catch (DomainException $exception) {
                Yii::$app->session->setFlash('error', $exception);
            }
        }

        return $this->render('index.twig', [
            'settings' => $this->configService->getAll()
        ]);
    }
}