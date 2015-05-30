<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Application;

/**
 * ApplicationSearch represents the model behind the search form about `frontend\models\Application`.
 */
class ApplicationSearch extends Application
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'company_id', 'job_id', 'score', 'sent', 'read', 'archived'], 'integer'],
            [['state', 'created_at'], 'safe'],
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
        $query = Application::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'company_id' => $this->company_id,
            'job_id' => $this->job_id,
            'score' => $this->score,
            'sent' => $this->sent,
            'read' => $this->read,
            'archived' => $this->archived,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'state', $this->state]);

        return $dataProvider;
    }
}
