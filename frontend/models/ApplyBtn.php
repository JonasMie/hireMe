<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "applyBtn".
 *
 * @property integer $id
 * @property integer $job_id
 * @property string $key
 * @property string $site
 * @property integer $clickCount
 * @property integer $viewCount
 *
 * @property Application[] $applications
 * @property Job $job
 */
class ApplyBtn extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'applyBtn';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['job_id'], 'required'],
            [['job_id', 'clickCount', 'viewCount'], 'integer'],
            [['key', 'site'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'job_id' => 'Job ID',
            'key' => 'Key',
            'site' => 'Site',
            'clickCount' => 'Click Count',
            'viewCount' => 'View Count',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplications()
    {
        return $this->hasMany(Application::className(), ['btn_id' => 'id']);
    }

    public function getApplicationRate() {

        if ($this->viewCount == 0) return 0;
        else return $this->clickCount/$this->viewCount*100;

    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJob()
    {
        return $this->hasOne(Job::className(), ['id' => 'job_id']);
    }
}
