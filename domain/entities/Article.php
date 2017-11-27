<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 11/23/17
 * Time: 10:54 AM
 */

namespace domain\entities;


use yii\base\Model;

class Article extends Model
{
    public $id;
    public $title;
    public $slug;
    public $categoryId;
    public $userId;
    public $author;

    public $textIntro;
    public $textBody;
    public $textBodyMarkdown;

    public $status;
    public $favorite;

    public $createdAt;
    public $updatedAt;
    public $publishingAt;

    private $meta;

    public function rules()
    {
        return [
            [['title', 'textIntro'], 'required'],
            [['categoryId', 'userId', 'status', 'favorite', 'createdAt', 'updatedAt', 'publishingAt'], 'integer'],
            [['title', 'slug'], 'string', 'max' => 256],
            [['author'], 'string', 'max' => 64],
            [['textIntro', 'textBody', 'textBodyMarkdown'], 'string'],
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
            'slug' => 'Slug',
            'categoryId' => 'Category',
            'userId' => 'User ID',
            'author' => 'Author',
            'textIntro' => 'Text Intro',
            'textBody' => 'Text Body',
            'textBodyMarkdown' => 'Text Body Markdown',
            'status' => 'Active',
            'favorite' => 'Favorite',
            'createdAt' => 'Created At',
            'updatedAt' => 'Updated At',
            'publishingAt' => 'Publishing At',
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