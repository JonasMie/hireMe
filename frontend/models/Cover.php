<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "cover".
 *
 * @property integer $id
 * @property string $title
 * @property integer $attachment_id
 * @property string $created_at
 *
 * @property File $attachment
 */
class Cover extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cover';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'title'], 'required'],
            [['id', 'attachment_id'], 'integer'],
            [['created_at'], 'safe'],
            [['title'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Title'),
            'attachment_id' => Yii::t('app', 'Attachment ID'),
            'created_at' => Yii::t('app', 'Created At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAttachment()
    {
        return $this->hasOne(File::className(), ['id' => 'attachment_id']);
    }
}
