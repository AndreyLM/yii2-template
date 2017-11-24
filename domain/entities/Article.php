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
            [['title', 'slug', 'text_intro'], 'required'],
            [['category_id', 'user_id', 'status', 'favorite', 'created_at', 'updated_at', 'publishing_at'], 'integer'],
            [['title', 'slug'], 'string', 'max' => 256],
            [['author'], 'string', 'max' => 64],
            [['text_intro', 'text_body', 'text_body_markdown'], 'string'],
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
            'category_id' => 'Category ID',
            'user_id' => 'User ID',
            'author' => 'Author',
            'text_intro' => 'Text Intro',
            'text_body' => 'Text Body',
            'text_body_markdown' => 'Text Body Markdown',
            'status' => 'Status',
            'favorite' => 'Favorite',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'publishing_at' => 'Publishing At',
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