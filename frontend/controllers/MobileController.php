<?php

namespace frontend\controllers;

use frontend\models\Job;
use frontend\models\Event;
use yii\helpers\BaseJson;

class MobileController extends \yii\web\Controller
{
    public function actionGetJobs()
    {
    	 $jobs = Job::find()
        ->orderBy('id')
        ->all();
        return BaseJson::encode($jobs);
    }

    public function actionGetEvents() {

    	$events = Event::find()
    	->orderBy('id')
    	->all();
        return BaseJson::encode($events);

    }

    public function actionCreateEvent($thisevent) {

    		$event = BaseJson::encode($thisevent);
    	$ev = new Event();
    	$ev->title = $event['title'];
    	$ev->description = $event['description'];
    	$ev->begin = $event['begin'];
    	$ev->end = $event['end'];
    	$ev->save();

    }

}
