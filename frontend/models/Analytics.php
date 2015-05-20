<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User;

class Analytics extends \yii\base\Model
{

    public function getJobs($id) {

        $jobs = Job::find()
        ->where(['company_id' => $id])
        ->orderBy('id')
        ->all();

        return $jobs;

    }

    //Overview
    public function getApplier($id) {

    	 $applications = Application::find()
        ->where(['company_id' => $id, 'sent' => 1,])
        ->orderBy('id')
        ->all();
        return $applications;

    }
    //Detail
    public function getAppliesForJob($id) {

    	 $applications = Application::find()
        ->where(['job_id' => $id, 'sent' => 1,])
        ->orderBy('id')
        ->all();

        return $applications;

    }
    //Overview
    public function getHired($id) {

    	 $hired = Application::find()
        ->where(['company_id' => $id , 'state' => 'Versendet'])
        ->orderBy('id')
        ->all();

        return $hired;
    }

    //Overview
    public function getAllViewsAndClicks($id) {

    	$jobs = Job::find()
    	->where(['company_id' => $id])
        ->orderBy('id')
        ->all();

        $views = 0;
        $clicks = 0;

        for ($i=0; $i < count($jobs) ; $i++) { 
        	$tmpId = $jobs[$i]->id;

        	$btns = ApplyBtn::find()
		    	->where(['job_id' => $tmpId])
		        ->orderBy('id')
		        ->all();

		        for($x=0;$x<count($btns); $x++) {

		        	$tmpViews = $btns[$x]->viewCount;
		        	$tmpClicks = $btns[$x]->clickCount;
		        	$views+=$tmpViews;
		        	$clicks+=$tmpClicks;
		        }
        }

        $data = [];
        $data[0] = $views;
        $data[1] = $clicks;

        return $data;

    }

    //Detail
    public function getAllViewsAndClicksForJob($id) {

        $views = 0;
        $clicks = 0;

        	$btns = ApplyBtn::find()
		    	->where(['job_id' => $id])
		        ->orderBy('id')
		        ->all();

		        for($x=0;$x<count($btns); $x++) {

		        	$tmpViews = $btns[$x]->viewCount;
		        	$tmpClicks = $btns[$x]->clickCount;
		        	$views+=$tmpViews;
		        	$clicks+=$tmpClicks;
		        }
  

        $data = [];
        $data[0] = $views;
        $data[1] = $clicks;

        return $data;

    }

    
}

?>