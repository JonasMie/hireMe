<?php

namespace frontend\controllers;

use common\behaviours\BodyClassBehaviour;
use Yii;
use frontend\models\Analytics;
use common\models\User;
use frontend\models\JobSearch;
use frontend\models\Job;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use frontend\models\ApplyBtn;
use frontend\models\Application;

class AnalyticsController extends Controller
{

    public function behaviors()
    {
        return [
            'bodyClasses' => [
                'class' => BodyClassBehaviour::className()
            ]
        ];
    }
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
         if ($clickCount == 0) {$applicationRate = 0;}
         else { $applicationRate = (count($applier)/$clickCount)*100;}
         if (count($applier) == 0) {
         $conversionRate = 0;
         }
         else {
         $conversionRate = count($hired)/count($applier);             
         }
    	 $clicks = [];
         $applications = [];
         if ($viewCount == 0) {$interestRate = 0;}
         else {$interestRate = ($clickCount/$viewCount)*100;}


        $jobProvider = new ActiveDataProvider([
        'query' => Job::find(['company_id' => $id]),
        'pagination' => [
            'pageSize' => 20,],
        ]);

         return $this->render('index', [
            'id' => $id,
            'applyCount' => count($applier),
            'hiredCount' => count($hired),
            'jobCount' =>   count($jobs),
            'viewCount' =>  $viewCount,
            'clickCount' => $clickCount,
            'applicationRate' => $applicationRate,
            'interviewRate' => $analytics->getInterviewRate($id),
            'interestRate' => $interestRate,
            'conversionRate' => $conversionRate,
            'companyName' =>  $analytics->getCompany($id),
            'provider' => $jobProvider,
        ]);


 }

   

 


    public function actionDetail($id) {

        $analytics = new Analytics();
        $applier = $analytics->getAppliesForJob($id);
        $viewClickData =  $analytics->getAllViewsAndClicksForJob($id);
        $viewCount = $viewClickData[0];
        $clickCount = $viewClickData[1];
        if ($clickCount == 0) {$applicationRate = 0;}
        else { $applicationRate = (count($applier)/$clickCount)*100;}        
        $job = Job::findOne($id);
        $jobName = $job->title;
        if ($viewCount == 0) {$interestRate = 0;}
        else {$interestRate = ($clickCount/$viewCount)*100;}

        Yii::trace(count(Analytics::getBtnsForJob($id)));

        $query = ApplyBtn::find()
        ->where(['job_id' => $id])
        ->orderBy('id');

        $jobProvider = new ActiveDataProvider([
        'query' => $query,
        'pagination' => [
            'pageSize' => 20,],
        ]);

         return $this->render('detail', [
            'id' => $job->company_id,
            'jobTitle' =>  $jobName,
            'applyCount' => count($applier),
            'viewCount' =>  $viewCount,
            'clickCount' => $clickCount,
            'interestRate' => $interestRate,
            'applicationRate' => $applicationRate,
            'interviewRate' => $analytics->getInterviewRateForJob($id),
            'provider' => $jobProvider,
        ]);
       

    }

}
