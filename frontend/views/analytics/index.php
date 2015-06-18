<?php

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\widgets\ListView;
use frontend\assets\CustomChartsAsset;
use yii\grid\GridView;

CustomChartsAsset::register($this);
$this->title = "Analytics für";

?>
<div class="myjobs">

    <h1><?= Html::encode($this->title) ?> <?= $companyName ?></h1>

    
    <p>


    <h1><?= $applyCount ?> Bewerbungen</h1>
    <h1><?= $hiredCount ?> Einstellungen</h1>
    <h1><?= $jobCount ?> Stellenanzeigen</h1>

    <h1>-------------------------------------------------------------------------------</h1>
    <canvas id="viewClickChart" class="chart"></canvas>
    <canvas id="interestRateChart" class="chart"></canvas>
    <br>
    <canvas id="clicksApplicationChart" class="chart"></canvas>
    <canvas id="applicationRateChart" class="chart"></canvas>
    <br>
    <canvas id="interviewApplicationChart" class="chart"></canvas>
    <canvas id="interviewRateChart" class="chart"></canvas>
    <br>
    <canvas id="applicationHiredChart" class="chart"></canvas>
    <canvas id="conversionRateChart" class="chart"></canvas>
    <br>
    <br>

   <?= GridView::widget([
        'dataProvider' => $provider,
        'columns'      => [
         [
                'label'  => 'Titel',
                'format' => 'raw',
                'value'  => function ($data) {
                    return \yii\helpers\Html::encode($data->title);
                }
            ],       
        [
                'label'  => 'Job Beginn',
                'format' => 'raw',
                'value'  => function ($data) {
                    return \yii\helpers\Html::encode($data->job_begin);
                }
            ],    
        [
                'label'  => 'Job Ende',
                'format' => 'raw',
                'value'  => function ($data) {
                    return \yii\helpers\Html::encode($data->job_end);
                }
        ],   
        [
                'label'  => 'Ansehen',
                'format' => 'raw',
                'value'  => function ($data) {
                    return \yii\helpers\Html::a(Html::button("Ansehen"),"/analytics/detail?id=".$data->id);
                }
        ],  
        ],
    ]); 

    ?>


</div>

