<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 12/7/17
 * Time: 9:14 AM
 */

namespace domain\entities\gallery;


class Photo
{
    public $id;
    public $gallery_id;
    public $thumb;
    public $origin;
    public $sort;

    const PHOTO_ORIGIN = 'origin';
    const PHOTO_THUMB_SMALL = 'thumb_small';
    const PHOTO_THUMB_MEDIUM = 'thumb_medium';
    const PHOTO_THUMB_BIG = 'thumb_big';
}