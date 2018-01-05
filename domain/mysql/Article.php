<?php

namespace domain\mysql;

use common\models\User;
use domain\mysql\behaviors\MetaBehavior;
use domain\mysql\queries\ArticleQuery;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
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
            [['title', 'text_intro'], 'required'],
            [['category_id', 'user_id', 'status', 'favorite', 'publishing_at'], 'integer'],
            [['title', 'slug'], 'string', 'max' => 256],
            [['author'], 'string', 'max' => 64],
            [['text_intro', 'text_body', 'text_body_markdown'], 'string'],
        ];
    }

    public function behaviors()
    {
        return [
            'meta' => [
                'class' => MetaBehavior::className(),
            ],
            'slug' => [
                'class' => SluggableBehavior::className(),
                'attribute' => 'title',
                // 'slugAttribute' => 'slug',
            ],
            'datetime' => [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
            ],
            'datetime2' => [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'publishing_at',
            ]
        ];
    }

    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
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
