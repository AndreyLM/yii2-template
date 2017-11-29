<?php

namespace domain\mysql;

use domain\mysql\behaviors\MetaBehavior;
use domain\mysql\queries\CategoryQuery;
use paulzi\nestedsets\NestedSetsBehavior;
use yii\behaviors\SluggableBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "category".
 *
 * @property int $id
 * @property string $title
 * @property string $name
 * @property string $description
 * @property string $meta_json
 * @property int $depth
 * @property int $rgt
 * @property int $lft
 * @property int $status
 *
 * @property Category parent
 */
class Category extends ActiveRecord
{
    public $meta;

    public function behaviors()
    {
        return [
            'meta' => MetaBehavior::className(),
            'nestedSets' => [
                'class' => NestedSetsBehavior::className(),
                // 'treeAttribute' => 'tree',
            ],
            'slug' => [
                'class' => SluggableBehavior::className(),
                'attribute' => 'title',
                'slugAttribute' => 'name',
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
     */
    public static function tableName()
    {
        return 'category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['meta_json'], 'string'],
            [['depth', 'rgt', 'lft', 'status'], 'integer'],
            [['title', 'description'], 'string', 'max' => 255],
            [['name'], 'string', 'max' => 32],
            [['name'], 'unique'],
        ];
    }


    /**
     * @inheritdoc
     * @return \domain\mysql\queries\CategoryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CategoryQuery(get_called_class());
    }

}
