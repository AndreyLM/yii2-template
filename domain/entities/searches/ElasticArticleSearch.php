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

class ElasticArticleSearch extends BaseArticleSearch
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
        $query = Article::find();

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
            'id' => $this->id,
            'category_id' => $this->categoryId,
            'user_id' => $this->userId,
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
            ->andFilterWhere(['like', 'text_body_markdown', $this->textBodyMarkdown])
            ->andFilterWhere(['like', 'meta_json', $this->metaJson]);

        $dataProvider->allModels = $query->all();

        return $dataProvider;
    }
}