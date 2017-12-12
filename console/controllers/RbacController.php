<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 12/12/17
 * Time: 1:34 PM
 */

namespace console\controllers;


use common\models\User;
use yii\console\Controller;

class RbacController extends Controller
{
    public function actionInit()
    {
        $authManager = \Yii::$app->authManager;

        $this->stdout('Initializing rbac basic system '. PHP_EOL);

        $this->stdout('1. Cleaning existing roles'.PHP_EOL);
        $authManager->removeAll();
        $this->stdout('Done!'.PHP_EOL);


        $this->stdout('2. Creating rbac system'. PHP_EOL);
        $admin = $authManager->createRole('admin');
        $manager = $authManager->createRole('manager');
        $user = $authManager->createRole('user');

        $authManager->add($admin);
        $authManager->add($user);
        $authManager->add($manager);

        $authManager->addChild($manager, $user);
        $authManager->addChild($admin, $manager);
        $this->stdout('Complete'. PHP_EOL);

        $defaultAdmin = User::findByUsername('andrew');
        $authManager->assign($admin, $defaultAdmin->id);

        $this->stdout($defaultAdmin->username .' has admin role!'. PHP_EOL);
    }
}