<?php

namespace frontend\Controllers;

use common\behaviours\BodyClassBehaviour;
use frontend\models\Application;
use frontend\models\ApplicationSearch;
use frontend\models\FavouritesSearch;
use frontend\models\JobContactsSearch;
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


        $messages = new MessageSearch();
        $messageDataProvider = $messages->search(['MessageSearch' =>['receiver_id' => Yii::$app->user->identity->getId()]]);
        $favourites = new FavouritesSearch();
        $favouritesDataProvider = $favourites->search(['FavouritesSearch' => ['user_id' => Yii::$app->user->identity->getId()]]);
        $jobContact = new JobContactsSearch();
        $jobDataProvider = $jobContact->search(['JobContactsSearch' => ['contact_id' => Yii::$app->user->identity->getId()]]);

        if(Yii::$app->user->identity->isRecruiter()){
            $searchModel =  new ApplicationSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('index', [
                'messageDP' => $messageDataProvider,
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'jobDP' => $jobDataProvider,
            ]);
        }

        return $this->render('index', [
            'messageDP' => $messageDataProvider,
            'favouritesDP' => $favouritesDataProvider,
            'jobDP' => $jobDataProvider,
        ]);
    }

}
