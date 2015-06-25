<?php

namespace frontend\models;

use common\models\User;
use Yii;

/**
 * This is the model class for table "favourites".
 *
 * @property integer $id
 * @property integer $job_ad_id
 * @property integer $user_id
 *
 * @property Job $job
 * @property User $user
 */
class Favourites extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'favourites';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[ 'job_id', 'user_id'], 'required'],
            [['id', 'job_id', 'user_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'job_id' => Yii::t('app', 'Job ID'),
            'user_id' => Yii::t('app', 'User ID'),
        ];
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
}
