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
                    'senderName' => [
                        'asc'  => ['other' => SORT_ASC],
                        'desc' => ['other' => SORT_DESC],
                        'label' => ['senderName']
                    ],
                ],
            'defaultOrder' => [
                'sent_at' => SORT_DESC
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->select(['message.*', 'IF (sender_id = '.Yii::$app->user->getId() .', (SELECT lastName FROM user WHERE id = receiver_id), (SELECT lastName FROM user WHERE id = sender_id)) as "other"']);

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
        $query->join('INNER JOIN', 'user', '(user.id = message.sender_id) AND user.fullName LIKE "%' . $this->senderName . '%"');
//        $query->join('INNER JOIN', 'user', '(user.id = message.receiver_id OR user.id = message.sender_id) AND user.fullName LIKE "%' . $this->senderName . '%"');
//        if (isset($this->senderName)) {
//            $query->join('RIGHT JOIN', 'user', '(user.id = message.receiver_id OR user.id = message.sender_id) AND user.fullName LIKE "%' . $this->senderName . '%"');


//        }
        return $dataProvider;
    }
}
