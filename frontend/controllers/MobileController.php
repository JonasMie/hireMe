<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Job;
use frontend\models\Event;
use yii\helpers\BaseJson;

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

}
