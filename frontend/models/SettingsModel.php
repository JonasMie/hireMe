<?php
/**
 * Created by Jonas Miederer.
 * User: jonas
 * Date: 25.05.15
 * Time: 14:17
 * Project: hireMe
 */

namespace frontend\models;

use common\models\User;
use Yii;
use yii\base\Model;

class SettingsModel extends Model{

    public $visibility;
    public $email;
    public $password;
    public $password_repeat;
    public $oldPassword;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email', 'visibility'], 'required'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'filter' => function($query){
                $query->andWhere(['id' => '!=' .Yii::$app->user->identity->getId()]);
            }],
            ['email', 'filter', 'filter' => 'trim'],


            ['password', 'string', 'min' => 6],
            ['password', 'compare'],
            ['password_repeat', 'required', 'when' => function($model){
                return !empty($model->password);
            },'whenClient'=> "function(attribute,value){
                    return $('#settingsmodel-password').val()!='';
            }"],
            ['oldPassword', 'required', 'when' => function($model){
                return !empty($model->password);
            }, 'whenClient'=> "function(attribute,value){
                    return $('#settingsmodel-password').val()!='';
            }"],
            ['oldPassword', function($attribute, $param) {
                if(!User::findIdentity(Yii::$app->user->identity->getId())->validatePassword($this->$attribute)){
                    $this->addError($attribute, 'Das Passwort stimmt nicht mit deinem aktuellen Passwort überein.');
                }
            }],

            ['visibility', 'in', 'range'=> [0,1,2]]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'visibility' => 'Sichtbarkeit',
            'oldPassword' => 'Altes Passwort',
            'password' => 'Neues Passwort',
            'password_repeat' => 'Passwort-Bestätigung'
        ];
    }

    /**
     * updates user settings
     *
     * @return User|null
     */
    public function update()
    {
        if($this->validate()){
            $user = User::findIdentity(Yii::$app->user->identity->getId());

            $user->email = $this->email;
            $user->visibility = $this->visibility;
            if(!empty($this->password)){
                $user->setPassword($this->password);
            }
            $user->generateAuthKey();
            if ($user->save()) {
                return $user;
            }
        } else {
            return null;
        }
    }
}