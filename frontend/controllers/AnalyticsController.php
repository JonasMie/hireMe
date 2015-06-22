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
use yii\helpers\BaseJson;
use yii\data\SqlDataProvider;


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
    public function actionJsonDetail($id) {

        $analytics = new Analytics();
        $applier = count($analytics->getAppliesForJob($id));
        $viewClickData =  $analytics->getAllViewsAndClicksForJob($id);
        $viewCount = $viewClickData[0];
        $clickCount = $viewClickData[1];
        if ($clickCount == 0) {$applicationRate = 0;}
        else { $applicationRate = (count($applier)/$clickCount)*100;}        
        $job = Job::findOne($id);
        $jobName = $job->title;
        if ($viewCount == 0) {$interestRate = 0;}
        else {$interestRate = ($clickCount/$viewCount)*100;}

        $jobData["applierCount"] = count($applier);
        $jobData["viewCount"] = $viewCount;
        $jobData["clickCount"] = $clickCount;
        $jobData["applicationRate"] = $applicationRate;
        $jobData["interviewCount"] = $analytics->getInterviewsForJob($id);
        $jobData["interviewRate"] = $analytics->getInterviewRateForJob($id);
        $jobData["interestRate"] = $interestRate;

       return BaseJson::encode($jobData);

    }

    public function actionJson() {

         $id = Yii::$app->user->identity->company_id;
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
         $conversionRate = count($hired)/count($applier)*100;             
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


        $generalData["companyName"] = $analytics->getCompany($id);
        $generalData["applierCount"] = count($applier);
        $generalData["hiredCount"] = count($hired);
        $generalData["jobCount"] = count($jobs);
        $generalData["viewCount"] = $viewCount;
        $generalData["clickCount"] = $clickCount;
        $generalData["applicationRate"] = $applicationRate;
        $generalData["interviewCount"] = $analytics->getAllInterviews($id);
        $generalData["interviewRate"] = $analytics->getInterviewRate($id);
        $generalData["interestRate"] = $interestRate;
        $generalData["conversionRate"] = $conversionRate;

       return BaseJson::encode($generalData);

    }

    public function actionIndex()
    {
         $id = Yii::$app->user->identity->company_id;
         Yii::trace("Company: ".$id);
    	 $analytics = new Analytics();
    	 $jobs = $analytics->getJobs($id);
         $applier = $analytics->getApplier($id);
         $hired = $analytics->getHired($id);

        $jobProvider = new ActiveDataProvider([
        'query' => Job::find()
        ->where(['company_id' => $id]),
        'pagination' => [
            'pageSize' => 20,],
        ]);

        $sql = "SELECT j.title, b.viewCount as views from job j, applyBtn b WHERE b.job_id = j.id and j.company_id = ".$id;

        $jobProvider = new SqlDataProvider([
            'sql' => $sql,
            'sort' => [
                'attributes' => [
                'title','views'
            ],
            'defaultOrder' => [
                'title' => SORT_ASC,
                'views' => SORT_ASC,
            ]
            ],
        ]);


         return $this->render('index', [
            'id' => $id,
            'applyCount' => count($applier),
            'hiredCount' => count($hired),
            'jobCount' =>   count($jobs),
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
