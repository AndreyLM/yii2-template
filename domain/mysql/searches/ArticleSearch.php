<?php

namespace domain\mysql\searches;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use domain\mysql\Article;

/**
 * ArticleSearch represents the model behind the search form of `domain\mysql\Article`.
 */
class ArticleSearch extends Article
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'category_id', 'user_id', 'status', 'favorite', 'created_at', 'updated_at', 'publishing_at'], 'integer'],
            [['title', 'slug', 'author', 'text_intro', 'text_body', 'text_body_markdown', 'meta_json'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Article::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'category_id' => $this->category_id,
            'user_id' => $this->user_id,
            'status' => $this->status,
            'favorite' => $this->favorite,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'publishing_at' => $this->publishing_at,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'slug', $this->slug])
            ->andFilterWhere(['like', 'author', $this->author])
            ->andFilterWhere(['like', 'text_intro', $this->text_intro])
            ->andFilterWhere(['like', 'text_body', $this->text_body])
            ->andFilterWhere(['like', 'text_body_markdown', $this->text_body_markdown])
            ->andFilterWhere(['like', 'meta_json', $this->meta_json]);

        return $dataProvider;
    }
}
