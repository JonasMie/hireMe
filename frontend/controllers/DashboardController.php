<?php

namespace frontend\Controllers;

use app\models\FavouritesSearch;
use app\models\JobSearch;
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
        return $this->render('index', [
            'messageDP' => $messageDataProvider,
            'favouritesDP' => $favouritesDataProvider,
            'jobDP' => $jobDataProvider,
        ]);
    }

}
