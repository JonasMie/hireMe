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
    public $company;
    public $jobDescription;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'job_id', 'user_id'], 'integer'],
            [['job', 'company', 'jobDescription'], 'safe'],
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
            'attributes'   => [
                'id',
                'jobBegin' => [
                    'asc'  => ['job_begin' => SORT_ASC],
                    'desc' => ['job_begin' => SORT_DESC],
                ],
                'jobDescription' => [
                    'asc'   => ['description' => SORT_ASC],
                    'desc'  => ['description' => SORT_DESC],
                    'label' => ['description']
                ],
                'company'        => [
                    'asc'   => ['name' => SORT_ASC],
                    'desc'  => ['name' => SORT_DESC],
                    'label' => ['name']
                ]
            ],
            'defaultOrder' => [
                'jobBegin' => SORT_DESC
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            $query->joinWith(['job']);
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id'      => $this->id,
            'job_id'  => $this->job_id,
            'user_id' => $this->user_id,
        ]);

        $query->joinWith(['job' => function ($q) {
            $q->where('job.description LIKE "%' .
                $this->jobDescription . '%"');
            $q->joinWith(['company' =>function($q1){
                $q1->where('company.name LIKE "%' .
                    $this->company . '%"');
            }]);
        }]);


        $query->andFilterWhere([
            'user_id' => Yii::$app->user->getId(),
        ]);


        return $dataProvider;
    }
}
