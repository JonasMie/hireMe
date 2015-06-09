<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "application_data".
 *
 * @property integer $id
 * @property integer $application_id
 * @property string $file_id
 * @property string $created_at
 *
 * @property Application $application
 */
class ApplicationData extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'application_data';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'application_id', 'file_id'], 'required'],
            [['id', 'application_id'], 'integer'],
            [['created_at'], 'safe'],
            [['file_id'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'application_id' => 'Application ID',
            'file_id' => 'File ID',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplication()
    {
        return $this->hasOne(Application::className(), ['id' => 'application_id']);
    }
}
