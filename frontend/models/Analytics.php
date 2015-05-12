<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User;

class Job extends Model
{
    public $company_id;
    public $jobs;


    public function initialize($id) {

        $company_id = $id;
        
    }

    public function getJobs() {

        $jobs = Job::find()
        ->where(['company_id' => $company_id])
        ->orderBy('id')
        ->all();

        return $jobs;

    }

    
}

?>