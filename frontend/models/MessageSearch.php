<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * MessageSearch represents the model behind the search form about `app\models\Message`.
 */
class MessageSearch extends Message
{

    /**
     * @var
     */
    public $senderName;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'sender_id', 'receiver_id', 'deleted', 'read'], 'integer'],
            [['subject', 'content', 'sent_at', 'senderName'], 'safe'],
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
     * @param boolean $or
     *
     * @return ActiveDataProvider
     */
    public function search($params, $or = true)
    {
        $query = Message::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $dataProvider->setSort([
            'attributes' => [
                'id',
                'sent_at',
//                'senderName' => [                            // TODO: Fix order by sender
//                    'asc' => ['user.lastName' => SORT_ASC],
//                    'desc' => ['user.lastName' => SORT_DESC],
//                    'label' => 'Von'
//                ]
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            $query->joinWith(['sender']);
            return $dataProvider;
        }
        if($or){
//            $query->where()
        } else {
            $query->andFilterWhere([
                'id'          => $this->id,
                'sender_id'   => $this->sender_id,
                'receiver_id' => $this->receiver_id,
                'sent_at'     => $this->sent_at,
                'deleted'     => $this->deleted,
                'read'        => $this->read,
            ]);

            $query->andFilterWhere(['like', 'subject', $this->subject])
                ->andFilterWhere(['like', 'content', $this->content]);
        }

//        $query->joinWith(['sender' => function($q){
//            $q->where('sender.lastName LIKE "%' .
//            $this->senderName .'%"');
//        }]);
        return $dataProvider;
    }
}
