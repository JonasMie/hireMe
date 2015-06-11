<?php

namespace frontend\controllers;

use common\behaviours\BodyClassBehaviour;
use frontend\models\ResumeJob;
use frontend\models\ResumeSchool;
use frontend\models\SettingsModel;
use common\models\User;
use Yii;
use yii\base\UserException;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;

class UserController extends Controller
{
    public function behaviors()
    {
        return [
            'access'      => [
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
                        'allow'   => true,
                        'roles'   => ['@'],
                    ],
                ]
            ],
            'bodyClasses' => [
                'class' => BodyClassBehaviour::className()
            ]
        ];
    }

    public function actionIndex($un = null)
    {
        if ($un !== null && $un != Yii::$app->user->identity->username) {
            $user = User::findByUsername($un);
            if ($user === null) {
                throw new UserException();      // TODO: throw error
            } else {
                return $this->render('index', [
                    'user' => $user
                ]);
            }
        } else {
            $jobDataProvider = new ActiveDataProvider([
                'query' => ResumeJob::find(['user_id' => Yii::$app->user->getId()]),
            ]);

            $schoolDataProvider = new ActiveDataProvider([
                'query' => ResumeSchool::find(['user_id' => Yii::$app->user->getId()]),
            ]);

            return $this->render('index', [
                'jobDataProvider'    => $jobDataProvider,
                'schoolDataProvider' => $schoolDataProvider,
                'user'               => Yii::$app->user->identity,
            ]);

        }

    }

    public function actionSettings()
    {
        $model = new SettingsModel();

        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->update()) {
                return $this->render('settings', [
                    'model'   => $model,
                    'success' => true,
                ]);
            } else {
                return $this->render('settings', [
                    'model'   => $model,
                    'success' => false,
                ]);
            }
        }
        $model->visibility = Yii::$app->user->identity->visibility;
        $model->email = Yii::$app->user->identity->email;
        return $this->render('settings', [
            'model' => $model,
        ]);
    }

    public function getUserName($id) {
        $usr = User::findOne($id);
        return $usr->username;
    }
}
