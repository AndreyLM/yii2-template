<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 12/8/17
 * Time: 10:10 AM
 */

namespace frontend\controllers;


use domain\formaters\NavMenuFormatter;
use domain\services\IMenuService;
use yii\base\Module;
use yii\web\Controller;

class SuperController extends Controller
{
    public $headerMenu;
    protected $menuService;

    public function __construct($id, Module $module, IMenuService $menuService, array $config = [])
    {
        $this->menuService = $menuService;
        $menu = $this->menuService->getMenu(IMenuService::MENU_HEADER);
        $this->headerMenu = $menuService->format(new NavMenuFormatter(), $menu->id);
        parent::__construct($id, $module, $config);
    }
}