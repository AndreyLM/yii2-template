<?php

namespace domain\mysql;

use domain\mysql\queries\MenuQuery;
use paulzi\nestedsets\NestedSetsBehavior;
use yii\behaviors\SluggableBehavior;
use yii\db\ActiveRecord;
use yiidreamteam\upload\ImageUploadBehavior;

/**
 * This is the model class for table "menu".
 *
 * @property int $id
 * @property string $title
 * @property string $name
 * @property string $description
 * @property string $img
 * @property int $type
 * @property int $relation
 * @property int $depth
 * @property int $rgt
 * @property int $lft
 * @property int $status
 */
class Menu extends ActiveRecord
{
    const ITEM_IMAGE_ORIGIN = 'origin';
    const ITEM_IMAGE_THUMB_SMALL = 'thumb_small';
    const ITEM_IMAGE_THUMB_MEDIUM = 'thumb_medium';
    const ITEM_IMAGE_THUMB_BIG = 'thumb_big';

    public static function tableName()
    {
        return '{{%menu}}';
    }

    public function behaviors()
    {
        return [
            'nestedSets' => [
                'class' => NestedSetsBehavior::className(),
                // 'treeAttribute' => 'tree',
            ],
            'slug' => [
                'class' => SluggableBehavior::className(),
                'attribute' => 'title',
                'slugAttribute' => 'name',
            ],
            [
                'class' => ImageUploadBehavior::className(),
                'attribute' => 'img',
                'createThumbsOnRequest' => true,
                'filePath' => '@staticRoot/origin/menu/[[id]].[[extension]]',
                'fileUrl' => '@static/origin/menu/[[id]].[[extension]]',
                'thumbPath' => '@staticRoot/cache/menu/[[profile]]_[[id]].[[extension]]',
                'thumbUrl' => '@static/cache/menu/[[profile]]_[[id]].[[extension]]',
                'thumbs' => [
                    self::ITEM_IMAGE_ORIGIN => ['width' => 800, 'height' => 600],
                    self::ITEM_IMAGE_THUMB_SMALL => ['width' => 57, 'height' => 57],
                    self::ITEM_IMAGE_THUMB_MEDIUM => ['width' => 150, 'height' => 150],
                    self::ITEM_IMAGE_THUMB_BIG => ['width' => 640, 'height' => 480],
                ],
            ],
        ];
    }

    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    /**
     * @inheritdoc
     * @return MenuQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MenuQuery(get_called_class());
    }
}
