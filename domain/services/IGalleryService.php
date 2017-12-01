<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 12/1/17
 * Time: 11:48 AM
 */

namespace domain\services;


use domain\entities\gallery\Gallery;
use domain\exceptions\DomainException;
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


}