<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 12/1/17
 * Time: 3:01 PM
 */

namespace domain\repositories;


use domain\entities\gallery\Gallery;
use domain\mysql\Gallery as ARGallery;
use domain\exceptions\DomainException;
use yii\web\NotFoundHttpException;

class MySqlGalleryRepository implements IGalleryRepository
{

    /* @return Gallery[] */
    public function getAll()
    {
        $galleries = [];
        $arGalleries = ARGallery::find()->all();
        foreach ($arGalleries as $arGallery)
        {
            $galleries[] = $this->mapGalleryToEntity($arGallery);
        }

        return $galleries;
    }

    /* @param $id int
     * @throws NotFoundHttpException
     * @return Gallery
     */
    public function getOne($id)
    {
        return $this->mapGalleryToEntity($this->find($id));
    }

    /* @param $gallery Gallery
     * @throws \RuntimeException
     * @throws DomainException
     * @return int
     */
    public function save(Gallery $gallery)
    {
        $arGallery = $this->mapGallaryToAR($gallery);

        if(!$arGallery->save())
            throw new \RuntimeException('Cannot save gallery');

        return $arGallery->id;
    }

    /* @param  $id int
     * @throws \RuntimeException
     * @return bool
     */
    public function delete($id)
    {
        $gallery = $this->find($id);
        if(!$gallery->delete())
            throw new \RuntimeException('Cannot delete gallery');

        return true;
    }

    private function find($id)
    {
        if(!$arGallery = ARGallery::findOne(['id' => $id]))
            throw new NotFoundHttpException('Can not fine gallery');

        return $arGallery;
    }

    private function mapGalleryToEntity(ARGallery $arGallery)
    {
        $gallery = new Gallery();

        $gallery->id = $arGallery->id;
        $gallery->title = $arGallery->title;
        $gallery->name = $arGallery->name;

        return $gallery;
    }

    private function mapGallaryToAR(Gallery $gallery)
    {
        $gallery->id ? $arGallery = $this->find($gallery->id) : $arGallery = new ARGallery();

        $arGallery->title = $gallery->title;
        $arGallery->name = $gallery->name;

        return $arGallery;
    }
}