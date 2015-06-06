<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;


/**
 * FavouritesSearch represents the model behind the search form about `frontend\models\Favourites`.
 */
class FavouritesSearch extends Favourites
{
    public $job;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'job_id', 'user_id'], 'integer'],
            [['job'], 'safe'],
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
        $query = Favourites::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->setSort([
            'attributes'=> [
                'id',
                'job.created_at' => [
                    'asc' => ['job.created_at' => SORT_ASC],
                    'desc' => ['job.created_at' => SORT_DESC],
                ],

            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'job_id' => $this->job_id,
            'user_id' => $this->user_id,
        ]);


        return $dataProvider;
    }
}
