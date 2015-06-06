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
         $conversionRate = count($hired)/count($applier);
    	 $clicks = [];
         $applications = [];
         if ($viewCount == 0) {$interestRate = 0;}
         else {$interestRate = ($clickCount/$viewCount)*100;}


        $dataProvider = new ActiveDataProvider([
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
            'provider' => $dataProvider,
        ]);


 }

    public function getApplicationRateForBtn($id) {

        $btn = ApplyBtn::findOne($id);
        $btnApplies = Application::find()
        ->where(['btn_id' => $id, 'sent' => 1,])
        ->orderBy('id')
        ->all();
        if ($btn->clickCount == 0) $rate = 0;
        else $rate =  (count($btnApplies)/$btn->clickCount)*100;
        return $rate;
    }

    public function getInterviewRateForBtn($id) {
        
        $btn = ApplyBtn::findOne($id);
        $applies = Application::find()
        ->where(['btn_id' => $id, 'sent' => 1])
        ->orderBy('id')
        ->all();

        $interviews = Application::find()
        ->where(['btn_id' => $id, 'sent' => 1, 'state' => 'Vorstellungsgespräch'])
        ->orderBy('id')
        ->all();
        if (count($applies) == 0) { $rate = 0;}
        else $rate =  (count($interviews)/count($applies))*100;
        return $rate;

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

    
        $dataProvider = new ActiveDataProvider([
        'query' => ApplyBtn::find(['job_id' => $id]),
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
            'provider' => $dataProvider,
        ]);
       

    }

}
