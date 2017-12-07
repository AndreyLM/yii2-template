<?php

namespace domain\mysql;

use yii\db\ActiveRecord;
use yiidreamteam\upload\ImageUploadBehavior;

/**
 * This is the model class for table "photo".
 *
 * @property int $id
 * @property int $gallery_id
 * @property string $file
 * @property int $sort
 *
 * @property Gallery $gallery
 */
class Photo extends ActiveRecord
{
    const PHOTO_ORIGIN = 'origin';
    const PHOTO_THUMB_SMALL = 'thumb_small';
    const PHOTO_THUMB_MEDIUM = 'thumb_medium';
    const PHOTO_THUMB_BIG = 'thumb_big';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%photo}}';
    }

    public function behaviors(): array
    {
        return [
            [
                'class' => ImageUploadBehavior::className(),
                'attribute' => 'file',
                'createThumbsOnRequest' => true,
                'filePath' => '@staticRoot/origin/galleries/[[attribute_gallery_id]]/[[id]].[[extension]]',
                'fileUrl' => '@static/origin/galleries/[[attribute_gallery_id]]/[[id]].[[extension]]',
                'thumbPath' => '@staticRoot/cache/galleries/[[attribute_gallery_id]]/[[profile]]_[[id]].[[extension]]',
                'thumbUrl' => '@static/cache/galleries/[[attribute_gallery_id]]/[[profile]]_[[id]].[[extension]]',
                'thumbs' => [
                    self::PHOTO_ORIGIN => ['width' => 800, 'height' => 600],
                    self::PHOTO_THUMB_SMALL => ['width' => 57, 'height' => 57],
                    self::PHOTO_THUMB_MEDIUM => ['width' => 150, 'height' => 150],
                    self::PHOTO_THUMB_BIG => ['width' => 640, 'height' => 480],
                ],
            ],
        ];
    }
}
