<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Job;
use frontend\models\Event;
use yii\helpers\BaseJson;
use common\models\User;
use frontend\models\Application;
use frontend\models\ApplicationData;
use frontend\models\Cover;
use frontend\models\Company;
use yii\db\Query;

class MobileController extends \yii\web\Controller
{
    public function actionGetJobs($event_id = false)
    {
        if ($event_id != false) {
        
        $jobs = Job::find()
        ->where(['event_id' => $event_id])
        ->orderBy('id')
        ->all();
        return BaseJson::encode($jobs);

        }
        else {
    	 $jobs = Job::find()
        ->orderBy('id')
        ->all();
        return BaseJson::encode($jobs);
        }
    }

    public function actionGetEvents() {

    	$events = Event::find()
    	->orderBy('id')
    	->all();
        return BaseJson::encode($events);

    }

    public function actionCreateEvent() {

            //$data = Yii::$app->request->get('data');
            //$data =  json_decode(utf8_encode(file_get_contents("php://input")), false);

            //$data = Yii::$app->request->post('data');   
            $data = Yii::$app->request['data'];
            // Found Indications retreiving by Categories
            return json_encode(['indic'=>'ok','postData'=>$data]);

        /*
    		$event = BaseJson::encode($thisevent);
    	$ev = new Event();
    	$ev->title = $event['title'];
    	$ev->description = $event['description'];
    	$ev->begin = $event['begin'];
    	$ev->end = $event['end'];
    	$ev->save();
    */
    }

    public function actionGetAppData($user) {

       // $appDatas = "SELECT f.title, f.id FROM file f WHERE NOT (f.title LIKE '%cover%') AND f.user_id = " . $user;
       $rows = (new \yii\db\Query())
        ->select(['file.title','file.id'])
        ->from('file')
        ->where(['file.user_id' => $user])
        ->all();
        return BaseJson::encode($rows);

    }

    public function actionSaveApp($user,$jobID,$data,$cover) {

        $usr = User::findOne($user);
        $job = Job::findOne($jobID);
        $company = Company::findOne($job->company_id);

        $app = new Application();
        $apps = Application::find()->orderBy('id')->all();
        if (count($apps) == 0) {$app->id = 0;} 
        else {
        $highestID = $apps[count($apps) - 1];
        $app->id = $highestID->id + 1;
        }

        $app->user_id = $usr->id;
        $app->job_id = $job->id;
        $app->company_id = $company->id;
        $app->score = 0;
        $app->state = "Gespeichert";
        $app->sent = 0;
        $app->read = 0;
        $app->archived = 0;
        $app->created_at = 0;
        if($app->save()) {

            for ($i=0; $i < count($data); $i++) { 
                
                $tmp = new ApplicationData();
                $appDatas = ApplicationData::find()->orderBy('id')->all();
                if (count($appDatas) == 0) {$tmp->id = 0;} 
                else {
                $highestID = $appDatas[count($appDatas) - 1];
                $tmp->id = $highestID->id + 1;
                }
                $tmp->application_id = $app->id;
                $tmp->file_id = $data[$i];
                $tmp->save();
                                return "go in";

            }

        }
    }

    public function actionApply($user,$job) {

            return "User ".User::findOne($user)->fullName." hat sich auf ".Job::findOne($job)->title." beworben.";

    }

}
