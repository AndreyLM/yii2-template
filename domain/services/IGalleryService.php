<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 12/1/17
 * Time: 11:48 AM
 */

namespace domain\services;


use domain\entities\gallery\Gallery;
use domain\entities\gallery\Photo;
use domain\exceptions\DomainException;
use domain\forms\UploadForm;
use http\Exception\RuntimeException;
use yii\web\NotFoundHttpException;

interface IGalleryService
{
    /* @return Gallery[] */
    public function getAll();

    /* @param $id int
     * @throws NotFoundHttpException
     * @return Gallery
     */
    public function getOne($id);

    /* @param $gallery Gallery
     * @throws \RuntimeException
     * @throws DomainException
     * @return int
     */
    public function save(Gallery $gallery);

    /* @param  $id int
     * @throws RuntimeException
     * @return bool
     */
    public function delete($id);

    /* @param $galleryId int
     * @param $photosForm \domain\forms\UploadForm
     * @throws DomainException
     * @return bool  */
    public function addPhotos($galleryId, UploadForm $photosForm);

    /* @param int $galleryId
     * @param string $origin
     * @param string $thumb
     * @return Photo[]
     * */
    public function getPhotos($galleryId, $origin, $thumb);

    /* @param int $id
     * @throws DomainException
     * @throws NotFoundHttpException
     * @return bool
     */
    public function deletePhoto($id);

    /* @param int $galleryId
     * @param int $photoId
     * @throws NotFoundHttpException
     * @throws DomainException
     * @return bool
     */
    public function movePhotoToStart($galleryId, $photoId);

    /* @param int $galleryId
     * @param int $photoId
     * @throws NotFoundHttpException
     * @throws DomainException
     * @return bool
     */
    public function movePhotoToEnd($galleryId, $photoId);

    /* @param int $galleryId
     * @param int $photoId
     * @throws NotFoundHttpException
     * @throws DomainException
     * @return bool
     */
    public function movePhotoNext($galleryId, $photoId);

    /* @param int $galleryId
     * @param int $photoId
     * @throws NotFoundHttpException
     * @throws DomainException
     * @return bool
     */
    public function movePhotoPrev($galleryId, $photoId);
}