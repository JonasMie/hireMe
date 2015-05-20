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
 * @property integer $contact_id
 * @property integer $company_id
 * @property integer $active
 * @property string $created_at
 * @property string $updated_at
 * @property string $title
 *
 * @property Application[] $applications
 * @property Favourites[] $favourites
 * @property Company $company
 * @property User $contact
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
            [['id', 'description', 'zip', 'sector', 'contact_id', 'company_id', 'active', 'title'], 'required'],
            [['id', 'sector', 'contact_id', 'company_id', 'active'], 'integer'],
            [['job_begin', 'job_end', 'created_at', 'updated_at'], 'safe'],
            [['description'], 'string', 'max' => 255],
            [['zip'], 'string', 'max' => 10],
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
            'contact_id' => 'Contact ID',
            'company_id' => 'Company ID',
            'active' => 'Active',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'title' => 'Title',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplications()
    {
        return $this->hasMany(Application::className(), ['job_id' => 'id']);
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
    
    public function getJobsByCompanyId($company) {
        return $this->hasMany(Application::className(), ['company_id' => $company]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContact()
    {
        return $this->hasOne(User::className(), ['id' => 'contact_id']);
    }
}
