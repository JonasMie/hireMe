<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "message_attachments".
 *
 * @property integer $id
 * @property integer $message_id
 * @property integer $file_id
 *
 * @property File $file
 * @property Message $message
 */
class MessageAttachments extends \yii\db\ActiveRecord
{
    public $uploadedFile;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'message_attachments';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['message_id', 'file_id'], 'integer'],
            [['uploadedFile'], 'file']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'message_id' => Yii::t('app', 'Message ID'),
            'file_id' => Yii::t('app', 'File ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFile()
    {
        return $this->hasOne(File::className(), ['id' => 'file_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMessage()
    {
        return $this->hasOne(Message::className(), ['id' => 'message_id']);
    }
}
