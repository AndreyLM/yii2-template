<?php

namespace domain\mysql;

use Yii;

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
class Menu extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'menu';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'name', 'depth', 'rgt', 'lft'], 'required'],
            [['type', 'relation', 'depth', 'rgt', 'lft', 'status'], 'integer'],
            [['title', 'description', 'img'], 'string', 'max' => 255],
            [['name'], 'string', 'max' => 32],
            [['name'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'name' => 'Name',
            'description' => 'Description',
            'img' => 'Img',
            'type' => 'Type',
            'relation' => 'Relation',
            'depth' => 'Depth',
            'rgt' => 'Rgt',
            'lft' => 'Lft',
            'status' => 'Status',
        ];
    }

    /**
     * @inheritdoc
     * @return \domain\mysql\queries\MenuQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \domain\mysql\queries\MenuQuery(get_called_class());
    }
}
