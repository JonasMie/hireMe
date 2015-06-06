<?php

namespace frontend\models;

use common\models\User;
use Yii;

/**
 * This is the model class for table "application".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $company_id
 * @property integer $job_id
 * @property integer $score
 * @property string $state
 * @property integer $sent
 * @property integer $read
 * @property integer $archived
 * @property string $created_at
 *
 * @property Company $company
 * @property Job $job
 * @property User $user
 * @property ApplicationData[] $applicationDatas
 */
class Application extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'application';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'company_id', 'job_id', 'state'], 'required'],
            [['id', 'user_id', 'company_id', 'job_id', 'score', 'sent', 'read', 'archived'], 'integer'],
            [['state'], 'string'],
            [['created_at'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [

            'id' => 'ID',
            'user_id' => 'User ID',
            'company_id' => 'Company ID',
            'job_id' => 'Job ID',
            'score' => 'Score',
            'state' => 'State',
            'sent' => 'Sent',
            'read' => 'Read',
            'archived' => 'Archived',
            'created_at' => 'Created At',

            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'company_id' => Yii::t('app', 'Company ID'),
            'job_id' => Yii::t('app', 'Job ID'),
            'score' => Yii::t('app', 'Score'),
            'state' => Yii::t('app', 'State'),
            'sent' => Yii::t('app', 'Sent'),
            'read' => Yii::t('app', 'Read'),
            'archived' => Yii::t('app', 'Archived'),
            'created_at' => Yii::t('app', 'Created At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompany()
    {
        return $this->hasOne(Company::className(), ['id' => 'company_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJob()
    {
        return $this->hasOne(Job::className(), ['id' => 'job_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicationDatas()
    {
        return $this->hasMany(ApplicationData::className(), ['application_id' => 'id']);
    }
}
