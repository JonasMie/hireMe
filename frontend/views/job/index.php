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
        'tableOptions' => ['class' => 'hireMeTable footable toggle-arrow', 'id' => 'inboxTable'],
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
                    return \yii\helpers\Html::encode("Bewerber: ".count(Analytics::getAppliesForJob($data->id)))." - ".\yii\helpers\Html::a("Analytics","/analytics/detail?id=".$data->id);
                }
            ],
            [
                'label'  => 'Actions',
                'format' => 'raw',
                'value'  => function ($data) {
                    
                    return Html::a(Yii::t('app', '<span class="glyphicon glyphicon-edit"></span>&nbsp;&nbsp;Bearbeiten'), ['update-job', 'id' => $data->id], ['class' => 'btn btn-success ripple btn-editJob'])." ". Html::a(Yii::t('app', '<span class="glyphicon glyphicon-edit"></span>&nbsp;&nbsp;Anschauen'), ['view', 'id' => $data->id], ['class' => 'btn btn-primary ripple btn-viewJob']);
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
        'tableOptions' => ['class' => 'hireMeTable footable toggle-arrow', 'id' => 'inboxTable'],
        'columns'      => [

                'title:text:Titel',
                'job_begin:text:Job beginnt',  
             [
                'label'  => 'Mehr',
                'format' => 'raw',
                'value'  => function ($data) {
                    return \yii\helpers\Html::a("Ansehen","/job/view?id=".$data->id);
                }
            ],    
        ],
    ]); ?>  
    
    </p>
<? endif; ?>
</div>