<?php
/**
 * Created by Jonas Miederer.
 * User: jonas
 * Date: 14.06.15
 * Time: 22:46
 * Project: hireMe
 */

namespace frontend\models;


use common\models\User;
use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

/**
 * This is the adapter class for table "message".
 *
 * @property string               $subject
 * @property string               $content
 * @property integer              $sender_id
 * @property integer              $receiver_id
 * @property string               $sent_at
 * @property integer              $read
 * @property integer              $flow
 *
 * @property User                 $sender
 * @property User                 $receiver
 *
 * @property MessageAttachments[] $messageAttachments
 */
class MessageCreate extends Model
{

    public $sender_id;
    public $receiver_id;
    public $subject;
    public $content;
    public $sent_at;
    public $read;
    public $flow;
    public $sender;
    public $receiver;
    public $attachment;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['subject', 'content', 'receiver'], 'required'],
            ['receiver', 'exist', 'targetClass' => 'common\models\User', 'targetAttribute' => 'fullName'],
            [['content'], 'string'],
            [['receiver_id', 'read', 'flow'], 'integer'],
            [['sent_at'], 'safe'],
            [['subject'], 'string', 'max' => 255],
            [['attachment'], 'file', 'extensions' => ['png', 'pdf', 'jpg', 'jpeg']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'          => 'ID',
            'subject'     => Yii::t('message', 'Subject'),
            'content'     => Yii::t('message', 'Content'),
            'sender_id'   => 'Sender ID',
            'receiver_id' => 'Receiver ID',
            'receiver'    => Yii::t('message', 'Receiver'),
            'sent_at'     => Yii::t('message', 'Sent'),
            'deleted_sender'     => Yii::t('message', 'Deleted'),
            'deleted_receiver'     => Yii::t('message', 'Deleted'),
            'read'        => Yii::t('message', 'Read'),
            'flow'        => Yii::t('message', 'Flow'),
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
        return $this->sender->firstName . " " . $this->sender->lastName;
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


    /**
     * saves the adapter-model in form of a message-model
     */
    public function save()
    {
        if ($this->validate()) {
            $receiver_id = User::findByFullname($this->receiver)->id;
            $message = new Message();
            $message->sender_id = \Yii::$app->user->getId();
            $message->receiver_id = $receiver_id;
            $message->subject = $this->subject;
            $message->content = nl2br($this->content);

            if ($message->save()) {
                $file = UploadedFile::getInstance($this, 'attachment');
                if ($file) {
                    $fileName = "/" . uniqid("ma_");
                    $upload = new MessageAttachments();
                    $upload->message_id = $message->primaryKey;
                    if ($upload->addFile($fileName, $file->extension, $file->size, $file->baseName) && $file->saveAs(Yii::getAlias('@webroot') . '/uploads/messattachments/' . $fileName . '.' . $file->extension)) {
                        return true;
                    }

                }
                return true;
            }
            return false;
        }
    }
}