<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 12/1/17
 * Time: 2:59 PM
 */

namespace domain\repositories;


use domain\entities\gallery\Gallery;
use domain\exceptions\DomainException;
use domain\forms\UploadForm;
use yii\web\NotFoundHttpException;

interface IGalleryRepository
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
     * @throws \RuntimeException
     * @return bool
     */
    public function delete($id);

    /* @param $galleryId int
     * @param $photosForm \domain\forms\UploadForm
     * @throws DomainException
     * @return bool
     */
    public function addPhotos($galleryId, UploadForm $photosForm);
}