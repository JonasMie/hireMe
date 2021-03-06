<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "qualification".
 *
 * @property integer $id
 * @property string $description
 * @property integer $file
 *
 * @property File $file0
 */
class Qualification extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'qualification';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['file'], 'integer'],
            [['description'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'description' => Yii::t('resume', 'Description'),
            'file' => Yii::t('file', 'File'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFile0()
    {
        return $this->hasOne(File::className(), ['id' => 'file']);
    }
}
