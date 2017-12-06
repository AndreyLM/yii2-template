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
                    'admin' => ['width' => 100, 'height' => 70],
                    'thumb' => ['width' => 640, 'height' => 480],
                    'cart_list' => ['width' => 150, 'height' => 150],
                    'cart_widget_list' => ['width' => 57, 'height' => 57],
                    'catalog_list' => ['width' => 228, 'height' => 228],

                ],
            ],
        ];
    }
}
