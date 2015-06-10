<?php

namespace frontend\models;

use common\models\User;
use frontend\helper\Setup;
use Yii;

/**
 * This is the model class for table "resume_job".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string  $begin
 * @property string  $end
 * @property integer|string $company_id
 * @property string  $type
 * @property integer $current
 * @property integer $report_id
 *
 * @property File    $report
 * @property Company $company
 * @property User    $user
 */
class ResumeJob extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'resume_job';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'company_id', 'type'], 'required'],
            [['user_id', 'current', 'report_id'], 'integer'],
            [['begin', 'end'], 'safe'],
            [['type'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'         => Yii::t('app', 'ID'),
            'user_id'    => Yii::t('app', 'User ID'),
            'begin'      => Yii::t('app', 'Beginn'),
            'end'        => Yii::t('app', 'Ende'),
            'company_id' => Yii::t('app', 'Unternehmen'),
            'type'       => Yii::t('app', 'Beruf'),
            'current'    => Yii::t('app', 'Aktuell'),
            'report_id'  => Yii::t('app', 'Anlage'),
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
    public function getCompany()
    {
        return $this->hasOne(Company::className(), ['id' => 'company_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
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
