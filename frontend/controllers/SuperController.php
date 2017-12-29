<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 12/8/17
 * Time: 10:10 AM
 */

namespace frontend\controllers;


use domain\formaters\NavMenuFormatter;
use domain\services\IConfigService;
use domain\services\IMenuService;
use yii\base\Module;
use yii\web\Controller;

class SuperController extends Controller
{
    public $headerMenu;
    protected $menuService;
    protected $configService;

    public function __construct($id, Module $module, IMenuService $menuService, IConfigService $configService, array $config = [])
    {
        $this->menuService = $menuService;
        $this->configService = $configService;
        $this->customSettings();
        parent::__construct($id, $module, $config);
    }

    private function customSettings()
    {
        $setting = $this->configService->getOne(IConfigService::HEADER_MENU);
        $this->headerMenu = $this->menuService->format(new NavMenuFormatter(), $setting->value);
    }
}