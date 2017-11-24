<?php

namespace domain\mysql;

use domain\mysql\behaviors\MetaBehavior;
use domain\mysql\queries\ArticleQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "article".
 *
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property int $category_id
 * @property int $user_id
 * @property string $author
 * @property string $text_intro
 * @property string $text_body
 * @property string $text_body_markdown
 * @property string $meta_json
 * @property int $status
 * @property int $favorite
 * @property int $created_at
 * @property int $updated_at
 * @property int $publishing_at
 */
class Article extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $meta;

    public static function tableName()
    {
        return '{{%article}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'slug', 'text_intro'], 'required'],
            [['category_id', 'user_id', 'status', 'favorite', 'created_at', 'updated_at', 'publishing_at'], 'integer'],
            [['meta_json'], 'string'],
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
            'meta_json' => 'Meta Json',
            'status' => 'Status',
            'favorite' => 'Favorite',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'publishing_at' => 'Publishing At',
        ];
    }

    public function behaviors()
    {
        return [
            'meta' => [
                'class' => MetaBehavior::className(),
            ],
        ];
    }

    /**
     * @inheritdoc
     * @return ArticleQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ArticleQuery(get_called_class());
    }
}
