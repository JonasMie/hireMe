<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Analytics;
use common\models\User;
use frontend\models\JobSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class AnalyticsController extends Controller
{
    public function actionIndex()
    {
    	$analytics = new Analytics();

        return $this->render('index', [
            'analytics' => $analytics,
        ]);
    }

}
