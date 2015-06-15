<?php
namespace common\models;

use frontend\models\Company;
use frontend\models\Favourites;
use frontend\models\Message;
use frontend\models\ResumeJob;
use frontend\models\ResumeSchool;
use frontend\models\File;
use frontend\models\JobContacts;
use kartik\helpers\Html;
use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Query;
use yii\helpers\Json;
use yii\web\IdentityInterface;
use yii\web\Response;

/**
 * User model
 *
 * @property integer        $id
 * @property string         $firstName
 * @property string         $lastName
 * @property string         $fullName
 * @property string         $username
 * @property string         $password_hash
 * @property string         $password_reset_token
 * @property string         $email
 * @property string         $auth_key
 * @property integer        $status
 * @property integer        $company_id
 * @property integer        $created_at
 * @property integer        $updated_at
 * @property string         $password write-only password
 * @property bool           $is_recruiter
 * @property integer        $visibility
 * @property string         $birthday
 * @property string         $position
 * @property Favourites[]   $favourites
 * @property JobContacts[]  $jobContacts
 * @property Message[]      $messages
 * @property ResumeJob[]    $resumeJobs
 * @property ResumeSchool[] $resumeSchools
 * @property File           $picture
 * @property Company        $company
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
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
            [['firstName', 'lastName', 'auth_key', 'email', 'fullName'], 'required'],
            [['status', 'is_recruiter', 'company_id', 'created_at', 'updated_at', 'picture_id', 'visibility'], 'integer'],
            [['birthday'], 'safe'],
            [['firstName', 'lastName', 'password_hash', 'password_reset_token', 'email', 'username', 'fullName'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['position'], 'string', 'max' => 45],
            [['username'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'                   => Yii::t('app', 'ID'),
            'firstName'            => Yii::t('app', 'First Name'),
            'lastName'             => Yii::t('app', 'Last Name'),
            'auth_key'             => Yii::t('app', 'Auth Key'),
            'password_hash'        => Yii::t('app', 'Password Hash'),
            'password_reset_token' => Yii::t('app', 'Password Reset Token'),
            'email'                => Yii::t('app', 'Email'),
            'status'               => Yii::t('app', 'Status'),
            'is_recruiter'         => Yii::t('app', 'Is Recruiter'),
            'company_id'           => Yii::t('app', 'Company ID'),
            'created_at'           => Yii::t('app', 'Created At'),
            'updated_at'           => Yii::t('app', 'Updated At'),
            'birthday'             => Yii::t('app', 'Birthday'),
            'position'             => Yii::t('app', 'Position'),
            'username'             => Yii::t('app', 'Username'),
            'fullName'             => Yii::t('app', 'Full Name'),
            'picture_id'              => Yii::t('app', 'Picture'),
            'visibility'           => Yii::t('app', 'Visibility'),
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
     * Finds user by username
     *
     * @param string $un username
     *
     * @return static|null
     */
    public static function findByUsername($un)
    {
        return static::findOne(['username' => $un, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by fullName
     *
     * @param string $fn fullName
     *
     * @return static|null
     */
    public static function findByFullname($fn)
    {
        return static::findOne(['fullName' => $fn, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by email
     *
     * @param string $email
     *
     * @return static|null
     */
    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     *
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status'               => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     *
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        $parts = explode('_', $token);
        $timestamp = (int)end($parts);
        return $timestamp + $expire >= time();
    }

    /**
     * Finds out if user is recruiter
     *
     * @param string $id to identify user
     *
     * @return boolean
     */
    public function getName()
    {
        return $this->firstName;
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    public function getCompanyId()
    {
        return $this->company_id;
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
     * Validates password
     *
     * @param string $password password to validate
     *
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    public function isRecruiter()
    {
        return $this->is_recruiter;
    }

    public static function getAutocompleteUser($q)
    {
        $query = User::find()
//            ->select('user.fullName, file.path')
            ->where('fullName LIKE "%' . $q . '%" AND user.id != ' . Yii::$app->user->identity->getId())
            ->with('picture')
            ->orderBy('fullName')
            ->all();
        $out = [];
        foreach ($query as $user) {
            $out[] = ['value' => $user->fullName, 'image' => isset($user->picture)?'thumbnails'.$user->picture->path:'default'];
        }
        return Json::encode($out);
    }

    public function getFavourites()
    {
        return $this->hasMany(Favourites::className(), ['user_id' => 'id']);
    }

    public function getJobContacts()
    {
        return $this->hasMany(JobContacts::className(), ['contact_id' => 'id']);
    }

    public function getMessages()
    {
        return $this->hasMany(Message::className(), ['sender_id' => 'id']);
    }

    public function getResumeJobs()
    {
        return $this->hasMany(ResumeJob::className(), ['user_id' => 'id']);
    }

    public function getResumeSchools()
    {
        return $this->hasMany(ResumeSchool::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPicture()
    {
        return $this->hasOne(File::className(), ['id' => 'picture_id']);
    }

    public function getCompany()
    {
        return $this->hasOne(Company::className(), ['id' => 'company_id']);
    }


    public function getProfilePicture($thumbnail = false)
    {
        if (isset($this->picture)) {
            $picture = File::findOne(['id' => $this->picture_id]);           // TODO: cachen
            if ($thumbnail) {
                return Html::img("/uploads/profile/thumbnails/" . $picture->path . ".jpg");
            }
            return Html::img("/uploads/profile" . $picture->path . ".jpg");
        }
        return Html::img("/uploads/profile/default.jpg");
    }
}