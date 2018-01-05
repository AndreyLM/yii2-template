<?php

namespace domain\entities\searches;


use yii\base\Model;
use domain\mysql\Article;
use yii\data\ArrayDataProvider;

/**
 * BaseArticleSearch represents the model behind the search form of `domain\mysql\Article`.
 */
abstract class BaseArticleSearch extends Model
{

    public $id;
    public $title;
    public $category;
    public $author;
    public $status;
    public $favorite;
    public $createdAt;
    public $updatedAt;
    public $publishingAt;
    public $slug;
    public $creator;
    public $textIntro;
    public $textBody;
    public $textBodyMarkdown;
    public $metaJson;

    public function rules()
    {
        return [
            [['id', 'status', 'favorite', 'createdAt', 'updatedAt', 'publishingAt'], 'integer'],
            [['title', 'creator', 'category', 'slug', 'author', 'textIntro', 'textBody', 'textBodyMarkdown', 'metaJson'], 'safe'],
        ];
    }


    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ArrayDataProvider
     */
    abstract public function search($params);
}
