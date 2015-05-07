<?php

namespace frontend\controllers;

use app\models\FavouritesSearch;
use frontend\models\MessageSearch;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

class UserController extends Controller
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

    }

}
