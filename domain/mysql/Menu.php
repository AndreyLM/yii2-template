<?php

namespace domain\mysql;

use domain\mysql\queries\MenuQuery;
use paulzi\nestedsets\NestedSetsBehavior;
use yii\behaviors\SluggableBehavior;
use yii\db\ActiveRecord;

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
    /**
     * @inheritdoc
     */
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
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['type', 'relation', 'depth', 'rgt', 'lft', 'status'], 'integer'],
            [['title', 'description', 'img'], 'string', 'max' => 255],
            [['name'], 'string', 'max' => 32],
            [['name'], 'unique'],
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
