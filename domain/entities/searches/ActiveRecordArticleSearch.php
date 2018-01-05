<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 1/5/18
 * Time: 10:42 AM
 */

namespace domain\entities\searches;


use domain\mysql\Article;
use yii\data\ArrayDataProvider;


class ActiveRecordArticleSearch extends BaseArticleSearch
{

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ArrayDataProvider
     */
    public function search($params)
    {
        $query = Article::find()->joinWith(['category', 'user']);

        // add conditions that should always apply here

        $dataProvider = new ArrayDataProvider();

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            $dataProvider->allModels = $query->all();

            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'article.id' => $this->id,
            'status' => $this->status,
            'favorite' => $this->favorite,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
            'publishing_at' => $this->publishingAt,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'slug', $this->slug])
            ->andFilterWhere(['like', 'author', $this->author])
            ->andFilterWhere(['like', 'text_intro', $this->textIntro])
            ->andFilterWhere(['like', 'text_body', $this->textBody])
            ->andFilterWhere(['like', 'category.title', $this->category])
            ->andFilterWhere(['like', 'user.username', $this->creator])
            ->andFilterWhere(['like', 'text_body_markdown', $this->textBodyMarkdown])
            ->andFilterWhere(['like', 'meta_json', $this->metaJson]);

        $models = [];
        foreach ($query->all() as $article) {
            $models[$article->id] = $this->mapToEntity($article, new self());
        }
        $dataProvider->allModels = $models;

        return $dataProvider;
    }

    private function mapToEntity(Article $article, BaseArticleSearch $entity)
    {
        $entity->id = $article->id;
        $entity->title = $article->title;
        $entity->category = $article->category->title;
        $entity->author = $article->author;
        $entity->status = $article->status;
        $entity->favorite = $article->favorite;
        $entity->createdAt = $article->created_at;
        $entity->updatedAt = $article->updated_at;
        $entity->publishingAt = $article->publishing_at;
        $entity->slug = $article->slug;
        $entity->creator = $article->user->username;
        $entity->textIntro = $article->text_intro;
        $entity->textBody = $article->text_body;
        $entity->textBodyMarkdown = $article->text_body_markdown;
        $entity->metaJson = $article->meta_json;

        return $entity;
    }
}