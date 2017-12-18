<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 12/18/17
 * Time: 11:04 AM
 */

namespace frontend\controllers;


use domain\formaters\renderer\NavContentMenuRenderer;

class ArticleController extends SuperController
{
    public function actionContent()
    {
        $res = $this->menuService->render(new NavContentMenuRenderer(), 1);
        echo $res;
    }
}