<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 11/24/17
 * Time: 11:45 AM
 */

namespace domain\entities\menu;


abstract class BaseMenu
{
    const TYPE_MENU = 1;
    const TYPE_ITEM = 2;
    const TYPE_ITEM_CATEGORY_BLOG = 3;
    const TYPE_ITEM_ARTICLE = 4;

    public $id;
    public $title;
    public $name;
    public $description;
    public $img;
    public $type ;

    public $depth;
    public $rgt;
    public $lft;
    public $status;

    public function rules()
    {
        return [
            [['title', 'name', 'depth', 'rgt', 'lft'], 'required'],
            [['type', 'relation', 'depth', 'rgt', 'lft', 'status'], 'integer'],
            [['title', 'description', 'img'], 'string', 'max' => 255],
            [['name'], 'string', 'max' => 32],
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
}