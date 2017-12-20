<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 11/24/17
 * Time: 11:53 AM
 */

namespace domain\entities\menu;


class Item extends Menu
{

    public $img = [];
    public $relation;
    public $depth;

    /* @var Menu*/
    public $menu;
    public $parentId;

    const ITEM_IMAGE_ORIGIN = 'origin';
    const ITEM_IMAGE_THUMB_SMALL = 'thumb_small';
    const ITEM_IMAGE_THUMB_MEDIUM = 'thumb_medium';
    const ITEM_IMAGE_THUMB_BIG = 'thumb_big';

    const TYPE_ITEM_CONTAINER = '2';
    const TYPE_ITEM_TABLE_OF_CONTENT = '3';
    const TYPE_ITEM_BLOG_ARTICLES = '4';
    const TYPE_FAVORITE_ARTICLES = '5';
    const TYPE_ITEM_ARTICLE = '6';

    public function rules()
    {
        return [
            [['title', 'parentId'], 'required'],
            [['type', 'relation', 'depth', 'status', 'parentId'], 'integer'],
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
            'status' => 'Active',
            'parentId' => 'Parent',
        ];
    }

    public function getItemTypes()
    {
        return [
            self::TYPE_ITEM_CONTAINER => 'Item container',
            self::TYPE_ITEM_TABLE_OF_CONTENT => 'Table of content',
            self::TYPE_ITEM_BLOG_ARTICLES => 'Blog of articles',
            self::TYPE_FAVORITE_ARTICLES => 'Favorite articles',
            self::TYPE_ITEM_ARTICLE => 'Article',
        ];
    }
}