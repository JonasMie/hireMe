<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "job".
 *
 * @property integer $id
 * @property string $description
 * @property string $job_begin
 * @property string $job_end
 * @property string $zip
 * @property integer $sector
 * @property integer $company_id
 * @property integer $active
 * @property string $created_at
 * @property string $updated_at
 * @property string $title
 * @property integer $type
 * @property string $city
 * @property integer $time
 * @property integer $allocated
 *
 * @property Application[] $applications
 * @property ApplyBtn[] $applyBtns
 * @property Favourites[] $favourites
 * @property Company $company
 * @property JobContacts[] $jobContacts
 */
class Job extends \yii\db\ActiveRecord
{

    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'job';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'description', 'sector', 'company_id', 'active', 'type', 'time'], 'required'],
            [['id', 'sector', 'company_id', 'active', 'type', 'time', 'allocated', 'distance'], 'integer'],
            [['job_begin', 'job_end', 'created_at', 'updated_at'], 'safe'],
            [['description', 'city'], 'string', 'max' => 255],
            [['title'], 'string', 'max' => 100],
            [['id'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'description' => Yii::t('job','Description'),
            'job_begin' => Yii::t('job','Job Begin'),
            'job_end' => Yii::t('job','Job End'),
            'zip' => Yii::t('geo','Zip'),
            'sector' => Yii::t('company','Sector'),
            'company_id' => Yii::t('company','Company ID'),
            'active' => Yii::t('job','Active'),
            'created_at' => Yii::t('job','Created At'),
            'updated_at' => Yii::t('job','Updated At'),
            'title' => Yii::t('job','Title'),
            'type' => Yii::t('job','Type'),
            'city' => Yii::t('geo','City'),
            'time' => Yii::t('job','Time'),
            'allocated' => Yii::t('job','Allocated'),
            'distance' => Yii::t('geo', 'Distance'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplications()
    {
        return $this->hasMany(Application::className(), ['job_id' => 'id']);
    }

    public static function getTitle($id) {

        $job = Job::findOne($id);
        return $job->title;

    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplyBtns()
    {
        return $this->hasMany(ApplyBtn::className(), ['job_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFavourites()
    {
        return $this->hasMany(Favourites::className(), ['job_id' => 'id']);
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
    public function getJobContacts()
    {
        return $this->hasMany(JobContacts::className(), ['job_id' => 'id']);
    }
}
