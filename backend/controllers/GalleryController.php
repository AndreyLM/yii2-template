<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 12/1/17
 * Time: 11:44 AM
 */

namespace backend\controllers;


use domain\entities\gallery\Gallery;
use domain\exceptions\DomainException;
use domain\services\GalleryService;
use yii\base\Module;
use yii\filters\VerbFilter;
use yii\web\Controller;

class GalleryController extends Controller
{
    private $galleryService;

    public function __construct($id, Module $module, array $config = [])
    {
        $this->galleryService = new GalleryService();

        parent::__construct($id, $module, $config);
    }

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

    public function actionIndex()
    {
        return $this->render('index.twig', [
            'model' => $this->galleryService->getAll()
        ]);
    }

    public function actionCreate()
    {
        $gallery = new Gallery();

        if($gallery->load(\Yii::$app->request->post())) {
            try {
                $id = $this->galleryService->save($gallery);
                \Yii::$app->session->setFlash('success', 'Gallery was successfully created');
                return $this->redirect('view', [
                    'id' => $id
                ]);
            } catch (DomainException $exception) {
                \Yii::$app->session->setFlash('error', $exception->getMessage());
            }
        }
        return $this->render('create.twig', [
            'model' => $gallery
        ]);
    }

    public function actionUpdate()
    {
        return $this->render('index.twig');
    }

    public function actionDelete()
    {
        return $this->render('index.twig');
    }
}