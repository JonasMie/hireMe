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

        if(Yii::$app->user->identity->isRecruiter() == false) {$this->redirect('/dashboard');}
        $analytics = new Analytics();
        $applier = $analytics->getAppliesForJob($id);

        $data= Yii::$app->db->createCommand("SELECT  sum(b.viewCount) as views, sum(b.clickCount) as clicks, round(SUM(b.clickCount)/SUM(b.viewCount)*100,2) as interestRate 
                        FROM job j
                        LEFT OUTER JOIN applyBtn b ON j.id = b.job_id
                        WHERE j.id =".$id."
                        GROUP BY j.title")->queryAll();

        $compareData = Yii::$app->db->createCommand("SELECT b.site, SUM(b.viewCount) as views, SUM(b.clickCount) as clicks  
                            FROM applyBtn b
                            INNER JOIN job j ON j.id = b.job_id
                            WHERE j.id = ".$id."
                            GROUP BY b.id")->queryAll();

        $jobData["compareData"] = $compareData;
        $jobData["viewCount"] = intval($data[0]['views']);
        $jobData["clickCount"] = intval($data[0]['clicks']);
        $jobData["applierCount"] = $applier;
        $jobData["interestRate"] = floatval($data[0]['interestRate']);
        if($jobData["clickCount"] == 0) { $jobData["applicationRate"] = 0;}
        else {
        $jobData["applicationRate"] = round($applier/$jobData["clickCount"]*100,2);
        }
        $jobData["interviewRate"] = $analytics->getInterviewRateForJob($id);
        $jobData["interviewCount"] = $analytics->getInterviewsForJob($id);

        return BaseJson::encode($jobData);
    }

    public function actionJson() {

        if(Yii::$app->user->identity->isRecruiter() == false) {$this->redirect('/dashboard');}
         $id = Yii::$app->user->identity->company_id;
         $analytics = new Analytics();
         $applier = $analytics->getApplier($id);
         $hired = $analytics->getHired($id);

        $data= Yii::$app->db->createCommand("SELECT  j.title, sum(b.viewCount) as views, sum(b.clickCount) as clicks, round(SUM(b.clickCount)/SUM(b.viewCount)*100,2) as interestRate 
                        FROM job j
                        LEFT OUTER JOIN applyBtn b ON j.id = b.job_id
                        INNER JOIN company c ON j.company_id = c.id
                        WHERE j.company_id =".$id."
                        GROUP BY j.title")->queryAll();

        $allClicks = 0;
        $allViews = 0;
        foreach ( $data as $row ) {
          $allViews += $row["views"];
          $allClicks += $row["clicks"];
        }

        if ($allClicks == 0) {$applicationRate = 0;}
        else { $applicationRate = round((count($applier)/$allClicks)*100,2);}

        if ($allViews == 0) {$interestRate = 0;}
        else {$interestRate = round(($allClicks/$allViews)*100,2);}

        if (count($applier) == 0) {$conversionRate = 0;}
        else {$conversionRate = round(count($hired)/count($applier)*100,2);}

        $jobProvider = new ActiveDataProvider([
        'query' => Job::find(['company_id' => $id]),
        'pagination' => [
            'pageSize' => 20,],
        ]);

        $compareViews = Yii::$app->db->createCommand("SELECT j.title, SUM(b.viewCount) as views 
                            FROM applyBtn b
                            LEFT OUTER JOIN job j ON j.id = b.job_id
                            WHERE j.company_id = ".$id."
                            GROUP BY j.title")->queryAll();

        $compareClicks = Yii::$app->db->createCommand("SELECT j.title, SUM(b.clickCount) as clicks 
                            FROM applyBtn b
                            LEFT OUTER JOIN job j ON j.id = b.job_id
                            WHERE j.company_id = ".$id."
                            GROUP BY j.title")->queryAll();

        $generalData["viewArray"] = $compareViews;
        $generalData["clickArray"] = $compareClicks;
        $generalData["applierCount"] = count($applier);
        $generalData["hiredCount"] = count($hired);
        $generalData["viewCount"] = $allViews;
        $generalData["clickCount"] = $allClicks;
        $generalData["applicationRate"] = $applicationRate;
        $generalData["interviewCount"] = $analytics->getAllInterviews($id);
        $generalData["interviewRate"] = $analytics->getInterviewRate($id);
        $generalData["interestRate"] = $interestRate;
        $generalData["conversionRate"] = $conversionRate;

        return BaseJson::encode($generalData);

    }

    public function actionIndex()
    {
         if(Yii::$app->user->identity->isRecruiter() == false) {$this->redirect('/dashboard');}
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

        $sql = "SELECT j.title, j.id, SUM(b.viewCount) as views, SUM(b.clickCount) as clicks, round(SUM(b.clickCount)/SUM(b.viewCount)*100,2) as interestRate 
                        FROM job j
                        LEFT OUTER JOIN applyBtn b ON j.id = b.job_id
                        WHERE j.company_id = ".$id."
                        GROUP BY j.title";
      
        $jobProvider = new SqlDataProvider([
            'sql' => $sql,
            'sort' => [
                'attributes' => [
                'title','views','clicks','interestRate',
            ],
            'defaultOrder' => [
                'title' => SORT_ASC,
                'views' => SORT_ASC,
                'clicks' => SORT_ASC,
                'interestRate' => SORT_ASC,
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
        
        if(Yii::$app->user->identity->isRecruiter() == false) {$this->redirect('/dashboard');}
        $analytics = new Analytics();
        $applier = $analytics->getAppliesForJob($id);
        $viewClickData =  $analytics->getAllViewsAndClicksForJob($id);
        $viewCount = $viewClickData[0];
        $clickCount = $viewClickData[1];
        if ($clickCount == 0) {$applicationRate = 0;}
        else { $applicationRate = round(($applier/$clickCount)*100,2);}        
        $job = Job::findOne($id);
        $jobName = $job->title;
        if ($viewCount == 0) {$interestRate = 0;}
        else {$interestRate = round(($clickCount/$viewCount)*100,2);}

        $query = ApplyBtn::find()
        ->where(['job_id' => $id])
        ->orderBy('id');

        $sql = "SELECT j.title, j.id, SUM(b.viewCount) as views, SUM(b.clickCount) as clicks, round(SUM(b.clickCount)/SUM(b.viewCount)*100,2) as interestRate 
                        FROM job j
                        LEFT OUTER JOIN applyBtn b ON j.id = b.job_id
                        GROUP BY j.title";


        $jobProvider = new ActiveDataProvider([
        'query' => $query,
        'pagination' => [
            'pageSize' => 20,],
        ]);

         return $this->render('detail', [
            'id' => $job->company_id,
            'jobID' => $job->id,
            'jobTitle' =>  $jobName,
            'applyCount' => $applier,
            'viewCount' =>  $viewCount,
            'clickCount' => $clickCount,
            'interestRate' => $interestRate,
            'applicationRate' => $applicationRate,
            'interviewRate' => $analytics->getInterviewRateForJob($id),
            'provider' => $jobProvider,
        ]);
       

    }

}
