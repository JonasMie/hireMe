<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\JobContacts;

/**
 * JobContactsSearch represents the model behind the search form about `frontend\models\JobContacts`.
 */
class JobContactsSearch extends JobContacts
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'job_id', 'contact_id'], 'integer'],
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
        $query = JobContacts::find();

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
            'job_id' => $this->job_id,
            'contact_id' => $this->contact_id,
        ]);

        return $dataProvider;
    }
}
