<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 12/1/17
 * Time: 11:44 AM
 */

namespace backend\controllers;


use domain\entities\gallery\Gallery;
use domain\entities\gallery\Photo;
use domain\exceptions\DomainException;
use domain\forms\UploadForm;
use domain\services\GalleryService;
use domain\services\IGalleryService;
use yii\base\Module;
use yii\filters\VerbFilter;
use yii\web\Controller;

class GalleryController extends Controller
{
    private $galleryService;

    public function __construct($id, Module $module, IGalleryService $galleryService, array $config = [])
    {
        $this->galleryService = $galleryService;

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

    public function actionView($id)
    {
        $gallery = $this->galleryService->getOne($id);
        $photos = $this->galleryService->getPhotos($gallery->id,
            Photo::PHOTO_ORIGIN, Photo::PHOTO_THUMB_MEDIUM);

        $photoUploadForm = new UploadForm();

        if($photoUploadForm->load(\Yii::$app->request->post()) && $photoUploadForm->validate()) {
            try {
                $this->galleryService->addPhotos($gallery->id, $photoUploadForm);
                \Yii::$app->session->setFlash('success', 'Photos were successfully uploaded');

            } catch (DomainException $exception) {
                \Yii::$app->session->setFlash('error', $exception->getMessage());
            }
        }

        return $this->render('view.twig', [
           'model' => $gallery,
           'uploadForm' => $photoUploadForm,
            'photos' => $photos
        ]);
    }

    public function actionCreate()
    {
        return $this->save(new Gallery(), 'create');
    }

    public function actionUpdate($id)
    {

        return $this->save($this->galleryService->getOne($id), 'update');
    }

    public function actionDelete($id)
    {
        try {
            $this->galleryService->delete($id);
            \Yii::$app->session->setFlash('success', 'Gallery was successfully deleted');
        } catch (DomainException $exception)
        {
            \Yii::$app->session->setFlash('error', $exception->getMessage());
        }

        return $this->redirect(['index']);
    }

    public function actionDeletePhoto($galleryId, $photoId)
    {
        try {
            $this->galleryService->deletePhoto($photoId);
            \Yii::$app->session->setFlash('success', 'Photo was successfully deleted');
        } catch (DomainException $exception) {
            \Yii::$app->session->setFlash('error', $exception->getMessage());
        }

        return $this->redirect(['view', 'id' => $galleryId]);
    }

    public function actionMovePhotoToStart($galleryId, $photoId)
    {
        try {
            $this->galleryService->movePhotoToStart($galleryId, $photoId);
            \Yii::$app->session->setFlash('success', 'Photo was successfully moved to start');
        } catch (DomainException $exception) {
            \Yii::$app->session->setFlash('error', $exception->getMessage());
        }

        return $this->redirect(['view', 'id' => $galleryId]);
    }

    public function actionMovePhotoToEnd($galleryId, $photoId)
    {
        try {
            $this->galleryService->movePhotoToEnd($galleryId, $photoId);
            \Yii::$app->session->setFlash('success', 'Photo was successfully moved to end');
        } catch (DomainException $exception) {
            \Yii::$app->session->setFlash('error', $exception->getMessage());
        }

        return $this->redirect(['view', 'id' => $galleryId]);
    }

    public function actionMovePhotoNext($galleryId, $photoId)
    {
        try {
            $this->galleryService->movePhotoNext($galleryId, $photoId);
            \Yii::$app->session->setFlash('success', 'Photo was successfully move photo to next');
        } catch (DomainException $exception) {
            \Yii::$app->session->setFlash('error', $exception->getMessage());
        }

        return $this->redirect(['view', 'id' => $galleryId]);
    }

    public function actionMovePhotoPrev($galleryId, $photoId)
    {
        try {
            $this->galleryService->movePhotoPrev($galleryId, $photoId);
            \Yii::$app->session->setFlash('success', 'Photo was successfully move photo to prev');
        } catch (DomainException $exception) {
            \Yii::$app->session->setFlash('error', $exception->getMessage());
        }

        return $this->redirect(['view', 'id' => $galleryId]);
    }

    private function save(Gallery $gallery, $view)
    {
        if($gallery->load(\Yii::$app->request->post())) {
            try {
                $id = $this->galleryService->save($gallery);
                \Yii::$app->session->setFlash('success', 'Gallery was successfully '.$view.'d');
                return $this->redirect(['view', 'id' => $id ]);
            } catch (DomainException $exception) {
                \Yii::$app->session->setFlash('error', $exception->getMessage());
            }
        }
        return $this->render($view.'.twig', [
            'model' => $gallery
        ]);
    }
}