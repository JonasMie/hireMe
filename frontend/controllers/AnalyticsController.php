<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Analytics;
use common\models\User;
use frontend\models\Job;
use frontend\models\JobSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use frontend\models\ApplyBtn;
use frontend\models\Application;

class AnalyticsController extends Controller
{
    public function actionIndex($id)
    {
    	 $analytics = new Analytics();
    	 $jobs = $analytics->getJobs($id);
         $applier = $analytics->getApplier($id);
         $hired = $analytics->getHired($id);


         //Interest and Clicks:
         $viewClickData =  $analytics->getAllViewsAndClicks($id);
         $viewCount = $viewClickData[0];
         $clickCount = $viewClickData[1];
         $conversionRate = (count($applier)/$clickCount)*100;

    	 $clicks = [];
         $applications = [];

         return $this->render('index', [
            'applyCount' => count($applier),
            'hiredCount' => count($hired),
            'jobCount' =>   count($jobs),
            'viewCount' =>  $viewCount,
            'clickCount' => $clickCount,
            'interestRate' => ($clickCount/$viewCount)*100,
            'conversionRate' => $conversionRate,
        ]);


 }

    public function actionDetail($id) {

        $analytics = new Analytics();
        $applier = $analytics->getAppliesForJob($id);
        $viewClickData =  $analytics->getAllViewsAndClicksForJob($id);
        $viewCount = $viewClickData[0];
        $clickCount = $viewClickData[1];
        $conversionRate = (count($applier)/$clickCount)*100;

         return $this->render('detail', [
            'applyCount' => count($applier),
            'viewCount' =>  $viewCount,
            'clickCount' => $clickCount,
            'interestRate' => ($clickCount/$viewCount)*100,
            'conversionRate' => $conversionRate,
        ]);
       

    }

}
