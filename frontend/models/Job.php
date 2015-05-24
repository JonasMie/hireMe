<?php

<<<<<<< HEAD
namespace frontend\models;
=======
namespace app\models;
>>>>>>> bc255c11865ac6559952248f9b47f4fe9381674c

use Yii;

/**
<<<<<<< HEAD
 * This is the model class for table "job".
=======
 * This is the model class for table "jobAd".
>>>>>>> bc255c11865ac6559952248f9b47f4fe9381674c
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
<<<<<<< HEAD
 * @property string $title
 *
 * @property Application[] $applications
 * @property Favourites[] $favourites
 * @property Company $company
 * @property User $contact
=======
 *
 * @property User $contact
 * @property Company $company
>>>>>>> bc255c11865ac6559952248f9b47f4fe9381674c
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
<<<<<<< HEAD
            [['id', 'description', 'zip', 'sector', 'contact_id', 'company_id', 'active', 'title'], 'required'],
            [['id', 'sector', 'contact_id', 'company_id', 'active'], 'integer'],
            [['job_begin', 'job_end', 'created_at', 'updated_at'], 'safe'],
            [['description'], 'string', 'max' => 255],
            [['zip'], 'string', 'max' => 10],
            [['title'], 'string', 'max' => 100],
            [['id'], 'unique']
=======
            [['id', 'description', 'zip', 'sector', 'contact_id', 'company_id', 'active'], 'required'],
            [['id', 'sector', 'contact_id', 'company_id', 'active'], 'integer'],
            [['job_begin', 'job_end', 'created_at', 'updated_at'], 'safe'],
            [['description'], 'string', 'max' => 255],
            [['zip'], 'string', 'max' => 10]
>>>>>>> bc255c11865ac6559952248f9b47f4fe9381674c
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
<<<<<<< HEAD
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
=======
            'id' => Yii::t('app', 'ID'),
            'description' => Yii::t('app', 'Description'),
            'job_begin' => Yii::t('app', 'Job Begin'),
            'job_end' => Yii::t('app', 'Job End'),
            'zip' => Yii::t('app', 'Zip'),
            'sector' => Yii::t('app', 'Sector'),
            'contact_id' => Yii::t('app', 'Contact ID'),
            'company_id' => Yii::t('app', 'Company ID'),
            'active' => Yii::t('app', 'Active'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
>>>>>>> bc255c11865ac6559952248f9b47f4fe9381674c
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
<<<<<<< HEAD
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
=======
    public function getContact()
    {
        return $this->hasOne(User::className(), ['id' => 'contact_id']);
>>>>>>> bc255c11865ac6559952248f9b47f4fe9381674c
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompany()
    {
        return $this->hasOne(Company::className(), ['id' => 'company_id']);
    }
<<<<<<< HEAD

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContact()
    {
        return $this->hasOne(User::className(), ['id' => 'contact_id']);
    }
=======
>>>>>>> bc255c11865ac6559952248f9b47f4fe9381674c
}
