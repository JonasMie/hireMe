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
            [['id', 'sector', 'company_id', 'active', 'type', 'time', 'allocated'], 'integer'],
            [['job_begin', 'job_end', 'created_at', 'updated_at'], 'safe'],
            [['description', 'city'], 'string', 'max' => 255],
            [['title'], 'string', 'max' => 100],
            [['id'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'description' => 'Description',
            'job_begin' => 'Job Begin',
            'job_end' => 'Job End',
            'zip' => 'Zip',
            'sector' => 'Sector',
            'company_id' => 'Company ID',
            'active' => 'Active',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'title' => 'Title',
            'type' => 'Type',
            'city' => 'City',
            'time' => 'Time',
            'allocated' => 'Allocated',
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
