<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 12/13/17
 * Time: 8:28 AM
 */

namespace backend\controllers;


use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;

class BaseController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'allow' => true,
                        'roles' => ['manager'],
                    ],
                ],

            'denyCallback' => function () {
                if (Yii::$app->user->isGuest) {
                    return Yii::$app->response->redirect(['site/login']);
                }

                throw new ForbiddenHttpException('You are not allowed to this page');
            }],

            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }
}