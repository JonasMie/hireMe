<?php

namespace frontend\Controllers;

use common\behaviours\BodyClassBehaviour;
use frontend\models\Application;
use frontend\models\ApplicationSearch;
use frontend\models\FavouritesSearch;
use frontend\models\Job;
use frontend\models\JobContacts;
use frontend\models\JobContactsSearch;
use frontend\models\Message;
use frontend\models\MessageSearch;
use Yii;
use yii\filters\AccessControl;

class DashboardController extends \yii\web\Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only'  => ['index'],
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow'   => true,  // TODO: set allow to false
                        'roles'   => ['@'], // TODO: set roles to '?'
                    ],
                ]
            ],
            'bodyClasses' => [
                'class' => BodyClassBehaviour::className()
            ]
        ];
    }

    public function actionIndex()
    {



        $favourites = new FavouritesSearch();
        $favouritesDataProvider = $favourites->search(['FavouritesSearch' => ['user_id' => Yii::$app->user->identity->getId()]]);


        if(Yii::$app->user->identity->isRecruiter()){

            $messages = Message::find()->where(['receiver_id'=>Yii::$app->user->getId(), 'read'=> 0])->count();

            $searchModel =  new ApplicationSearch();
            $applicationProvider = $searchModel->search(Yii::$app->request->queryParams,true);


            $jobContacts = JobContacts::find()->where(['contact_id'=>Yii::$app->user->getId()]);
            $jobs = $jobContacts->count();

            $applicationsProto = $jobContacts->join('RIGHT JOIN', 'application', 'application.job_id = job_contacts.job_id')->where(['contact_id'=>Yii::$app->user->getId()]);
            $totalApplications = $applicationsProto->count();
            $newApplications = $applicationsProto->andWhere(['read'=>0])->count();

            return $this->render('index', [
                'messages' => $messages,
                'searchModel' => $searchModel,
                'applicationProvider' => $applicationProvider,
                'jobs' => $jobs,
                'totalApplications' => $totalApplications,
                'newApplications' => $newApplications
            ]);
        }
        $messages = new MessageSearch();
        $messageDataProvider = $messages->search(['MessageSearch' =>['receiver_id' => Yii::$app->user->identity->getId()]]);
        return $this->render('index', [
            'messageDP' => $messageDataProvider,
            'favouritesDP' => $favouritesDataProvider,
        ]);
    }

}
