<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\ResumeSchool;

/**
 * ResumeSchoolSearch represents the model behind the search form about `frontend\models\ResumeSchool`.
 */
class ResumeSchoolSearch extends ResumeSchool
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'current', 'report_id'], 'integer'],
            [['begin', 'end', 'schoolname', 'graduation'], 'safe'],
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
        $query = ResumeSchool::find();

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
            'begin' => $this->begin,
            'end' => $this->end,
            'current' => $this->current,
            'report_id' => $this->report_id,
        ]);

        $query->andFilterWhere(['like', 'schoolname', $this->schoolname])
            ->andFilterWhere(['like', 'graduation', $this->graduation]);

        return $dataProvider;
    }
}
