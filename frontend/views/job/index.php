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
$this->params['breadcrumbs'][] = ['label' => 'Jobs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="_myjobs">

    <h1><?= Html::encode($this->title) ?></h1>   
    <p>


<? if (Yii::$app->user->identity->isRecruiter()): ?>

 <?= GridView::widget([
        'dataProvider' => $provider,
        'columns'      => [
         [
                'label'  => '  ',
                'format' => 'raw',
                'value'  => function ($data) {
                    return \yii\helpers\Html::checkbox("checkbox",false);
                }
            ],    
                'title:text:Titel',
                'job_begin:text:Job beginnt',   
            [

                'label'  => 'Info',
                'format' => 'raw',
                'value'  => function ($data) {
                    return \yii\helpers\Html::encode("Bewerber: ".count(Analytics::getAppliesForJob($data->id)))." - ".\yii\helpers\Html::a("Analytics","/analytics/detail?id=".$data->id)." - ".\yii\helpers\Html::a("Bearbeiten","/job/update?id=".$data->id);
                }
            ],
           
        ],
        'caption'  => Html::decode("<a href='http://frontend/job/create'><button>Neue Stellenanzeige</button></a>")
    ]); ?>  

    

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