<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 11/20/17
 * Time: 2:36 PM
 */

namespace domain\entities;


use yii\base\Model;

class Category extends Model
{
    public $id;
    public $title;
    public $name;
    public $description;
    public $depth;
    public $rgt;
    public $lft;
    public $status;

    public $meta;

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'name' => 'Name',
            'description' => 'Description',
            'meta_json' => 'Meta Json',
            'depth' => 'Depth',
            'rgt' => 'Rgt',
            'lft' => 'Lft',
            'status' => 'Status',
        ];
    }

    public function rules()
    {
        return [
            [['title', 'name', 'depth', 'rgt', 'lft'], 'required'],
            [['meta_json'], 'string'],
            [['depth', 'rgt', 'lft', 'status'], 'integer'],
            [['title', 'description'], 'string', 'max' => 255],
            [['name'], 'string', 'max' => 32],
            [['name'], 'unique'],
        ];
    }
}