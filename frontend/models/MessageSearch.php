<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * MessageSearch represents the model behind the search form about `frontend\models\Message`.
 */
class MessageSearch extends Message
{

    /**
     * @var $senderName String
     */
    public $senderName;

    public function attributes()
    {
        // add related fields to searchable attributes
        return array_merge(parent::attributes(), ['senderName']);
    }

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
     * @param array   $params
     * @param boolean $or
     *
     * @return ActiveDataProvider
     */
    public function search($params, $or = false)
    {
        $query = Message::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $dataProvider->setSort([
            'attributes'   =>
                [
                    'sent_at'    => [
                        'asc'     => ['sent_at' => SORT_ASC],
                        'desc'    => ['sent_at' => SORT_DESC],
                        'label'   => 'Gesendet',
                        'default' => SORT_DESC
                    ],
                    'subject'    => [
                        'asc'  => ['subject' => SORT_ASC],
                        'desc' => ['subject' => SORT_DESC]
                    ],
                    'senderName' => [                            // TODO: Fix order by sender
                        'asc'  => ['user.lastName' => SORT_ASC],
                        'desc' => ['user.lastName' => SORT_DESC],
                        'label' => ['senderName']
                    ],
                ],
            'defaultOrder' => [
                'sent_at' => SORT_DESC
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            $query->joinWith(['sender']);
            return $dataProvider;
        }

        $query->andWhere(
            ['or', '`receiver_id` = ' .Yii::$app->user->identity->getId() .' AND `deleted` = 0', ['sender_id' => Yii::$app->user->identity->getId()]]
        );
        $query->andFilterWhere([
            'sent_at' => $this->sent_at,
            'deleted' => $this->deleted,
            'read'    => $this->read,
        ]);

        $query->andFilterWhere(['like', 'subject', $this->subject])
            ->andFilterWhere(['like', 'content', $this->content]);

        if (isset($this->senderName)) {
            $query->join('RIGHT JOIN', 'user', '(user.id = message.receiver_id OR user.id = message.sender_id) AND user.fullName LIKE "%' . $this->senderName . '%"');
//            $query->joinWith(['receiver' => function ($q) {
//                $q->from('user receiver')->onCondition('receiver.fullName LIKE "%' . $this->senderName . '%"');
//            }], true, 'right JOIN');
//
//            $query->joinWith(['sender' => function ($q) {
//                $q->from('user sender')->onCondition('sender.fullName LIKE "%' . $this->senderName . '%"');
//            }], true, 'left JOIN');

        }
        return $dataProvider;
    }
}
