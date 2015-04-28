<?php
namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * ApplyBtn model
 *
 * @property integer $id
 * @property integer $company_id
 * @property integer $recruiter_id
 * @property integer $status
 */

class ApplyBtn extends ActiveRecord
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%applyBtn}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }
      /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

 /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

   
    /**
     * Finds user by company id
     *
     * @param string $compID
     * @return static|null
     */
    public static function findByCompanyID($compID)
    {
        return static::findOne(['company_id' => $compID, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by recruiterID
     *
     * @param string $recID
     * @return static|null
     */
    public static function findByRecruiterID($recID)
    {
        return static::findOne(['recruiter_id' => $compID, 'status' => self::STATUS_ACTIVE]);
    }


}
