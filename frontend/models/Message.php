<?php

namespace frontend\models;

use common\models\User;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "message".
 *
 * @property integer $id
 * @property string $subject
 * @property string $content
 * @property integer $sender_id
 * @property integer $receiver_id
 * @property string $sent_at
 * @property integer $deleted_sender
 * @property integer $deleted_receiver
 * @property integer $read
 * @property integer $flow
 *
 * @property User $sender
 * @property User $receiver
 *
 * @property MessageAttachments[] $messageAttachments
 */
class Message extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'message';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['subject', 'content', 'sender_id', 'receiver_id'], 'required'],
            [['content'], 'string'],
            [['sender_id', 'receiver_id', 'deleted_sender','deleted_receiver', 'read', 'flow'], 'integer'],
            [['sent_at'], 'safe'],
            [['subject'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'subject' => Yii::t('message', 'Subject'),
            'content' => Yii::t('message','Content'),
            'sender_id' => 'Sender ID',
            'receiver_id' => 'Receiver ID',
            'sent_at' => Yii::t('message', 'Sent'),
            'deleted_sender' => Yii::t('message', 'Deleted'),
            'deleted_receiver' => Yii::t('message', 'Deleted'),
            'read' => Yii::t('message', 'Read'),
            'flow' => Yii::t('message','Flow'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSender()
    {
        return $this->hasOne(User::className(), ['id' => 'sender_id']);
    }

    public function getSenderName()
    {
        return $this->sender->firstName ." " .$this->sender->lastName;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReceiver()
    {
        return $this->hasOne(User::className(), ['id' => 'receiver_id']);
    }

    public function belongsToUser($userId, $messageId)
    {
        return $this->find()->where(['id' => $messageId, 'receiver_id' => $userId])->orWhere(['id' => $messageId, 'sender_id' => $userId])->one();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMessageAttachments()
    {
        return $this->hasMany(MessageAttachments::className(), ['message_id' => 'id']);
    }

//    /**
//     * @return \yii\db\ActiveQuery
//     */
//    public function getPrev()
//    {
//        return $this->hasOne(Message::className(), ['id' => 'prev']);
//    }
}
