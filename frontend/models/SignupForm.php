<?php
namespace frontend\models;

use common\models\User;
use yii\base\Model;
use Yii;


/**
 * Signup form
 */
class SignupForm extends Model
{
    public $firstName;
    public $lastName;
    public $email;
    public $password;
    public $password_repeat;
    public $checkCompanySignup;
    public $companyName;
    public $companyAddressStreet;
    public $companyAddressNumber;
    public $companyAddressZIP;
    public $companyAddressCity;
    public $companySector;
    public $companyEmployees;
    public $visibility;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['$firstName', 'filter', 'filter' => 'trim'],
            ['$firstName', 'required'],
            ['$firstName', 'string', 'min' => 2, 'max' => 255],

            ['$lastName', 'filter', 'filter' => 'trim'],
            ['$lastName', 'required'],
            ['$lastName', 'string', 'min' => 2, 'max' => 255],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Diese Email-Adresse wird bereits verwendet.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],
            ['password_repeat', 'compare', 'compareAttribute' => 'password'],

            ['password_repeat', 'required'],

            ['visibility', 'default', 'value' => 0],


            [['companyName'], 'required', 'when' => function ($model) {
                return $model->checkCompanySignup == true;
            }, 'whenClient'                      => 'function(attribute,value){
                    return $("#checkCompanySignup").prop("checked");
                }'
            ],
            [['companyAddressStreet', 'companyAddressZIP', 'companyAddressCity', 'companySector', 'companyEmployees'], 'required', 'when' => function ($model) {
                return ($model->checkCompanySignup == true && Company::findByName($model->companyName) === null);
            }
                , 'whenClient'                                                                                                            => 'function(attribute,value){
                return (selVal != $("#signupform-companyname").val() && $("#checkCompanySignup").prop("checked"))}'
            ],
            ['companyAddressNumber', 'required', 'when' => function ($model) {
                return ($model->checkCompanySignup == true && Company::findByName($model->companyName) === null);
            }, 'whenClient'                             => 'function(attribute,value){
                      return (selVal != $("#signupform-companyname").val() && $("#checkCompanySignup").prop("checked"))}'
                , 'message'                             => 'Nr. fehlt'],



            ['companyAddressZIP', 'exist', 'targetClass' => Geo::className(), 'targetAttribute' => 'plz'],
            ['checkCompanySignup', 'boolean'],

            ['companySector', 'integer', 'min' => 0, 'max' => 99],
            ['companyEmployees', 'integer', 'min' => 0, 'max' => 3],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            '$firstName'            => Yii::t('user', 'First Name'),
            '$lastName'             => Yii::t('user', 'Last Name'),
            'email'                => Yii::t('user', 'Email'),
            'password'             => Yii::t('user', 'Password'),
            'checkCompanySignup'   => Yii::t('company', 'Check Company Signup'),
            'companyName'          => Yii::t('company', 'Company Name'),
            'companyAddressStreet' => Yii::t('company', 'Company Address Street'),
            'companyAddressNumber' => Yii::t('company', 'Company Address Number'),
            'companyAddressZIP'    => Yii::t('company', 'Company Address ZIP'),
            'companyAddressCity'   => Yii::t('company', 'Company Address City'),
            'companySector'        => Yii::t('company', 'Company Sector'),
            'companyEmployees'     => Yii::t('company', 'Company Employees'),
            'visibility'           => Yii::t('user', 'Visibility'),
        ];

    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {

        if ($this->validate()) {

            $user = new User();
            $user->$firstName = $this->$firstName;
            $user->$lastName = $this->$lastName;
            $user->fullName = $this->$firstName . " " . $this->$lastName;
            $user->username = $this->generateUsername($this->$firstName, $this->$lastName);
            

            $user->email = $this->email;
            $user->setPassword($this->password);

            if ($this->checkCompanySignup):
                $company = Company::findByName($this->companyName);


                if (!$company):
                    $company = new Company();
                    $company->name = $this->companyName;
                    $company->street = $this->companyAddressStreet;
                    $company->houseno = $this->companyAddressNumber;
                    $company->zip = $this->companyAddressZIP;
                    $company->city = $this->companyAddressCity;
                    $company->sector = $this->companySector;
                    $company->employeeAmount = $this->companyEmployees;

                    $company->save();

                endif;

                $user->is_recruiter = 1;
                $user->company_id = $company->id;
            endif;
            $user->generateAuthKey();
            if ($user->save()) {
                return $user;
            }
        }
        return null;
    }

    public static function generateUsername($firstName, $lastName)
    {
        $count = User::find()->where(['firstName' => $firstName, 'lastName' => $lastName])->count();

        switch ($count) {
            case 0:
                $username = $lastName;
                break;
            case 1:
                $username = $firstName . '-' . $lastName;
                break;
            case 2:
                $username = $firstName . '.' . $lastName;
                break;
            case 3:
                $username = $lastName . '-' . $firstName;
                break;
            case 4:
                $username = $lastName . '_' . $firstName;
                break;
            case 5:
                $username = $firstName . $lastName;
                break;
            case 6:
                $username = $lastName . $firstName;
                break;
            case 7:
                $username = substr($firstName, 0, 1) . $lastName;
                break;
            default:
                $username = $firstName . $lastName . ($count - 7);
        }

        return $username;
    }
}
