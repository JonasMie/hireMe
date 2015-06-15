<?php

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\widgets\ListView;
use yii\grid\GridView;
use frontend\models\analytics;
use frontend\models\MyJobsGridView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Job */

$this->title = $indiTitle;

?>

<div class="_myjobs">

    <h1><?= Html::encode($this->title) ?></h1>   
    <p>


<? if (Yii::$app->user->identity->isRecruiter()): ?>

 <?= GridView::widget([
        'id'=>'jobList',
        'dataProvider' => $provider,
        'columns'      => [
        [
                'class'         => 'yii\grid\CheckboxColumn',
                'filterOptions' => function () {
                    echo Html::dropDownList('action', '', ['' => 'Mark selected as: ', 'c' => 'Confirmed', 'nc' => 'No Confirmed'], ['class' => 'dropdown']);
                }
            ],
                'title:text:Titel',
                'job_begin:text:Job beginnt',   
            [

                'label'  => 'Info',
                'format' => 'raw',
                'value'  => function ($data) {
                    $analytics = new Analytics();
                    return \yii\helpers\Html::encode("Bewerber: ".count($analytics->getAppliesForJob($data->id)))." - ".\yii\helpers\Html::a("Analytics","/analytics/detail?id=".$data->id);
                }
            ],
            [
                'label'  => 'Actions',
                'format' => 'raw',
                'value'  => function ($data) {
                    return \yii\helpers\Html::a(Yii::t('app', 'Update'), ['update-job', 'id' => $data->id], ['class' => 'btn btn-primary'])." ". \yii\helpers\Html::a(Yii::t('app', 'View'), ['view', 'id' => $data->id], ['class' => 'btn btn-primary']);
                }
                    

            ],
           
        ],
        'caption'  => Html::decode("<a href='http://frontend/job/create'><button>Neue Stellenanzeige</button></a>")
    ]); ?>  
<!--
-->

<? else: ?>

<?= GridView::widget([
        'dataProvider' => $provider,
        'columns'      => [

                'title:text:Titel',
                'job_begin:text:Job beginnt',  
             [
                'label'  => 'Mehr',
                'format' => 'raw',
                'value'  => function ($data) {
                    return \yii\helpers\Html::a("Will ich!","/job/view?id=".$data->id);
                }
            ],    
        ],
    ]); ?>  
    
    </p>
<? endif; ?>
</div>