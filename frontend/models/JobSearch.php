<?php

<<<<<<< HEAD
namespace frontend\models;
=======
namespace app\models;
>>>>>>> bc255c11865ac6559952248f9b47f4fe9381674c

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
<<<<<<< HEAD
use frontend\models\Job;

/**
<<<<<<< HEAD
 * JobSearch represents the model behind the search form about `frontend\models\Job`.
=======
 * JobSearch represents the model behind the search form about `app\models\Job`.
>>>>>>> Complete generated files (views, models & controllers) and minor changes
=======
use app\models\Job;

/**
 * JobSearch represents the model behind the search form about `app\models\Job`.
>>>>>>> bc255c11865ac6559952248f9b47f4fe9381674c
 */
class JobSearch extends Job
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
<<<<<<< HEAD
<<<<<<< HEAD
            [['id', 'sector', 'contact_id', 'company_id', 'active'], 'integer'],
            [['description', 'job_begin', 'job_end', 'zip', 'created_at', 'updated_at', 'title'], 'safe'],
=======
            [['id', 'sector', 'company_id', 'active', 'type', 'time', 'allocated'], 'integer'],
            [['description', 'job_begin', 'job_end', 'zip', 'created_at', 'updated_at', 'city'], 'safe'],
>>>>>>> Complete generated files (views, models & controllers) and minor changes
=======
            [['id', 'sector', 'company_id', 'active', 'type', 'time', 'allocated'], 'integer'],
            [['description', 'job_begin', 'job_end', 'zip', 'created_at', 'updated_at', 'city'], 'safe'],
>>>>>>> bc255c11865ac6559952248f9b47f4fe9381674c
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
        $query = Job::find();

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
            'job_begin' => $this->job_begin,
            'job_end' => $this->job_end,
            'sector' => $this->sector,
            'company_id' => $this->company_id,
            'active' => $this->active,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'type' => $this->type,
            'time' => $this->time,
            'allocated' => $this->allocated,
        ]);

        $query->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'zip', $this->zip])
<<<<<<< HEAD
            ->andFilterWhere(['like', 'title', $this->title]);
            ->andFilterWhere(['like', 'city', $this->city]);
=======
            ->andFilterWhere(['like', 'city', $this->city]);

>>>>>>> bc255c11865ac6559952248f9b47f4fe9381674c
        return $dataProvider;
    }
}
