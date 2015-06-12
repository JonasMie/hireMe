<?php

namespace frontend\controllers;

use frontend\models\Job;
use yii\helpers\BaseJson;

class MobileController extends \yii\web\Controller
{
    public function actionIndex()
    {
    	 $jobs = Job::find()
        ->orderBy('id')
        ->all();
        return BaseJson::encode($jobs);
    }

}
