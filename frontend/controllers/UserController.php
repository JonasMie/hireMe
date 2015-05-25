<?php

namespace frontend\controllers;

use app\models\FavouritesSearch;
use app\models\ResumeJob;
use app\models\ResumeSchool;
use common\models\User;
use frontend\models\MessageSearch;
use frontend\models\Resume;
use Yii;
use yii\base\UserException;
use yii\filters\AccessControl;
use yii\web\Controller;

class UserController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only'  => ['index', 'settings'],
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow'   => true,  // TODO: set allow to false
                        'roles'   => ['@'], // TODO: set roles to '?'
                    ],
                    [
                        'actions' => ['settings'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ]
            ]
        ];
    }

    public function actionIndex($un=null)
    {
        if($un!==null && $un!=Yii::$app->user->identity->username){
            $user = User::findByUsername($un);
            if($user===null){
                throw new UserException();      // TODO: throw error
            } else {
                return $this->render('index', [
                    'user' => $user
                ]);
            }
        } else {
            $jobResume =  ResumeJob::find()->where(['user_id' => Yii::$app->user->identity->getId()])->orderBy('current', 'end')->all();
            $schoolResume =  ResumeSchool::find()->where(['user_id' => Yii::$app->user->identity->getId()])->orderBy('current', 'end')->all();
            return $this->render('index', [
                'resumeJob' => $jobResume,
                'resumeSchool' => $schoolResume,
                'user' => Yii::$app->user->identity,
            ]);
        }

    }
    public function actionSettings()
    {
        return $this->render('settings');
    }
}
