<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "resume_school".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $begin
 * @property string $end
 * @property string $schoolname
 * @property integer $report_id
 *
 * @property File $report
 * @property User $user
 */
class ResumeSchool extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'resume_school';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'begin', 'end', 'schoolname'], 'required'],
            [['user_id', 'report_id'], 'integer'],
            [['begin', 'end'], 'safe'],
            [['schoolname'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'begin' => Yii::t('app', 'Begin'),
            'end' => Yii::t('app', 'End'),
            'schoolname' => Yii::t('app', 'Schoolname'),
            'report_id' => Yii::t('app', 'Report ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReport()
    {
        return $this->hasOne(File::className(), ['id' => 'report_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
