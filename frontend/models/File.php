<?php

namespace frontend\models;

use common\models\User;
use Yii;

/**
 * This is the model class for table "file".
 *
 * @property integer $id
 * @property string $path
 * @property string $extension
 * @property integer $size
 * @property string $title
 *
 * @property Cover[] $covers
 * @property MessageAttachments[] $messageAttachments
 * @property Qualification[] $qualifications
 * @property ResumeJob[] $resumeJobs
 * @property ResumeSchool[] $resumeSchools
 * @property User[] $users
 */
class File extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'file';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['path'], 'string', 'max' => 255],
            // TODO: rules for file (size & extension)
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'path' => Yii::t('app', 'Path'),
            'extension' => Yii::t('app', 'Extension'),
            'size' => Yii::t('app', 'Size'),
            'title' => Yii::t('app', 'Title'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCovers()
    {
        return $this->hasMany(Cover::className(), ['attachment_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMessageAttachments()
    {
        return $this->hasMany(MessageAttachments::className(), ['file_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQualifications()
    {
        return $this->hasMany(Qualification::className(), ['file' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResumeJobs()
    {
        return $this->hasMany(ResumeJob::className(), ['report_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResumeSchools()
    {
        return $this->hasMany(ResumeSchool::className(), ['report_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['picture' => 'id']);
    }
}
