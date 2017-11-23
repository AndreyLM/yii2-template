<?php

namespace domain\mysql\searches;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use domain\mysql\Category;

/**
 * CategorySearch represents the model behind the search form of `domain\mysql\Category`.
 */
class CategorySearch extends Category
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'depth', 'rgt', 'lft', 'status'], 'integer'],
            [['title', 'name', 'description', 'meta_json'], 'safe'],
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
        $query = Category::find()->orderBy('lft');

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
            'depth' => $this->depth,
            'rgt' => $this->rgt,
            'lft' => $this->lft,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'meta_json', $this->meta_json]);

        return $dataProvider;
    }
}
