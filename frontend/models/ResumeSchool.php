<?php

namespace frontend\models;

use frontend\helper\Setup;
use Yii;

/**
 * This is the model class for table "resume_school".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $begin
 * @property string $end
 * @property integer $current
 * @property string $schoolname
 * @property integer $report_id
 * @property string $graduation
 *
 * @property User $user
 * @property File $report
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
            [['user_id', 'begin', 'end', 'schoolname', 'graduation'], 'required'],
            [['user_id', 'current'], 'integer'],
            [['begin', 'end'], 'safe'],
            [['schoolname', 'graduation'], 'string', 'max' => 255],
            ['report_id', 'file', 'extensions' => ['pdf']]
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
            'current' => Yii::t('app', 'Current'),
            'schoolname' => Yii::t('app', 'Schoolname'),
            'report_id' => Yii::t('app', 'Report ID'),
            'graduation' => Yii::t('app', 'Graduation'),
        ];
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
    public function getReport()
    {
        return $this->hasOne(File::className(), ['id' => 'report_id']);
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $this->begin = Setup::convert($this->begin);
            $this->end = Setup::convert($this->end);
            return true;
        } else {
            return false;
        }
    }
}
