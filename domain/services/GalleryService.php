<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 12/1/17
 * Time: 2:58 PM
 */

namespace domain\services;


use domain\entities\gallery\Gallery;
use domain\exceptions\DomainException;
use domain\forms\UploadForm;
use domain\repositories\MySqlGalleryRepository;
use http\Exception\RuntimeException;
use yii\web\NotFoundHttpException;

class GalleryService implements IGalleryService
{
    private $galleryRepository;

    public function __construct()
    {
        $this->galleryRepository = new MySqlGalleryRepository();
    }

    /* @return Gallery[] */
    public function getAll()
    {
        return $this->galleryRepository->getAll();
    }

    /* @param $id int
     * @throws NotFoundHttpException
     * @return Gallery
     */
    public function getOne($id)
    {
        return $this->galleryRepository->getOne($id);
    }

    /* @param $gallery Gallery
     * @throws \RuntimeException
     * @throws DomainException
     * @return int
     */
    public function save(Gallery $gallery)
    {
        $this->validate($gallery);
        return $this->galleryRepository->save($gallery);
    }

    /* @param  $id int
     * @throws RuntimeException
     * @return bool
     */
    public function delete($id)
    {
        $this->galleryRepository->delete($id);
    }

    private function validate(Gallery $gallery)
    {
        if(!$gallery->validate())
            throw new DomainException('Please enter correct values');

        return true;
    }

    /* @param $galleryId int
     * @param $photosForm \domain\forms\UploadForm
     * @throws DomainException
     * @return bool
     */
    public function addPhotos($galleryId, UploadForm $photosForm)
    {
        return $this->galleryRepository->addPhotos($galleryId, $photosForm);
    }
}