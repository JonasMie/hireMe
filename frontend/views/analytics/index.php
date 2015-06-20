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



    <div class="row" id="analytics-tiles">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 analytics-tile analytics-tile-1 tile-black ripple" onclick="window.location='./application';">
            <div class="subtile subtile-left">
                <div class="tile-value tile-number">
                    <?= Html::a($applyCount, "/bewerbungen"); ?>
                </div>
                <div class="tile-value tile-string">
                    <?= Html::a('Bewerbungen insgesamt', "/bewerbungen"); ?>
                </div>
            </div>
            <div class="subtile subtile-right hidden-xs">

            </div>
        </div>

        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 analytics-tile analytics-tile-2 tile-green ripple">
            <div class="subtile subtile-left">
                <div class="tile-value tile-number">
                    <div class="a-analytics"><?=$hiredCount?></div>
                </div>
                <div class="tile-value tile-string">
                    <div class="a-analytics">Neue Mitarbeiter</div>
                </div>
            </div>
            <div class="subtile subtile-right hidden-xs">

            </div>
        </div>

        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 analytics-tile analytics-tile-3 tile-black ripple" onclick="window.location='./job';">
            <div class="subtile subtile-left">
                <div class="tile-value tile-number">
                    <?= Html::a($jobCount, "/job"); ?>
                </div>
                <div class="tile-value tile-string">
                    <?= Html::a('Stellenanzeigen', "/job"); ?>
                </div>
            </div>
            <div class="subtile subtile-right hidden-xs">

            </div>
        </div>

    </div>

    <div id="analyticsCharts">

        <div id="charts-first-row" class="row">
            <div class="col-lg-4">
                <canvas id="viewClickChart" class="chart"></canvas>
            </div>
            <div class="col-lg-4">
                <canvas id="interestRateChart" class="chart"></canvas>
            </div>
        </div>

        <div id="charts-second-row" class="row">
            <canvas id="clicksApplicationChart" class="chart"></canvas>
            <canvas id="applicationRateChart" class="chart"></canvas>
        </div>

        <div id="charts-third-row" class="row">
            <canvas id="interviewApplicationChart" class="chart"></canvas>
            <canvas id="interviewRateChart" class="chart"></canvas>
        </div>

        <div id="charts-fourth-row" class="row">
            <canvas id="applicationHiredChart" class="chart"></canvas>
            <canvas id="conversionRateChart" class="chart"></canvas>
        </div>

    </div>

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

