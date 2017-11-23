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
    public $status;
    public $parentId;
    public $lvl;

    /* @var Meta*/
    private $meta;

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'name' => 'Name',
            'description' => 'Description',
            'status' => 'Active',
            'parent' => 'Parent',
        ];
    }

    public function rules()
    {
        return [
            [['title', 'name', 'parentId'], 'required'],
            [['parentId', 'status'], 'integer'],
            [['title', 'description'], 'string', 'max' => 255],
            [['name'], 'string', 'max' => 32],
        ];
    }

    public function setMeta(Meta $meta) : void
    {
        $this->meta = $meta;
    }

    public function getMeta() : Meta
    {
        return $this->meta;
    }
}