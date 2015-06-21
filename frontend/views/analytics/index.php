<?php

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\widgets\ListView;
use frontend\assets\CustomChartsAsset;
use yii\grid\GridView;
use frontend\models\Analytics;

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


    <!-- CHARTS -->

    <div id="analyticsCharts">

        <div id="charts-first-row" class="row">
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 chartTile first-col">
                <div class="background-wrapper">
                    <div class="header">
                        Views und Clicks
                        <span class="glyphicon glyphicon-info-sign pull-right" data-toggle="tooltip" data-placement="left" title="Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet."></span>
                    </div>
                    <canvas id="viewClickChart" class="chart"></canvas>
                </div>
            </div>

            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 chartTile second-col">
                <div class="background-wrapper">
                    <div class="header">
                        Interesst Rate
                        <span class="glyphicon glyphicon-info-sign pull-right" data-toggle="tooltip" data-placement="left" title="Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet."></span>
                    </div>
                    <canvas id="interestRateChart" class="chart"></canvas>
                </div>
            </div>
        </div>

        <div id="charts-second-row" class="row">
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 chartTile first-col">
                <div class="background-wrapper">
                    <div class="header">
                        Clicks und Bewerbungen
                        <span class="glyphicon glyphicon-info-sign pull-right" data-toggle="tooltip" data-placement="left" title="Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet."></span>
                    </div>
                    <canvas id="clicksApplicationChart" class="chart"></canvas>
                </div>
            </div>

            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 chartTile second-col">
                <div class="background-wrapper">
                    <div class="header">
                        Application Rate
                        <span class="glyphicon glyphicon-info-sign pull-right" data-toggle="tooltip" data-placement="left" title="Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet."></span>
                    </div>
                    <canvas id="applicationRateChart" class="chart"></canvas>
                </div>
            </div>
        </div>

        <div id="charts-third-row" class="row">
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 chartTile first-col">
                <div class="background-wrapper">
                    <div class="header">
                        Bewerbungen und Interviews
                        <span class="glyphicon glyphicon-info-sign pull-right" data-toggle="tooltip" data-placement="left" title="Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet."></span>
                    </div>
                    <canvas id="interviewApplicationChart" class="chart"></canvas>
                </div>
            </div>

            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 chartTile second-col">
                <div class="background-wrapper">
                    <div class="header">
                        Interview Rate
                        <span class="glyphicon glyphicon-info-sign pull-right" data-toggle="tooltip" data-placement="left" title="Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet."></span>
                    </div>
                    <canvas id="interviewRateChart" class="chart"></canvas>
                </div>
            </div>
        </div>

        <div id="charts-fourth-row" class="row">
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 chartTile first-col">
                <div class="background-wrapper">
                    <div class="header">
                        Was des Digga?
                        <span class="glyphicon glyphicon-info-sign pull-right" data-toggle="tooltip" data-placement="left" title="Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet."></span>
                    </div>
                    <canvas id="applicationHiredChart" class="chart"></canvas>
                </div>
            </div>

            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 chartTile second-col">
                <div class="background-wrapper">
                    <div class="header">
                        Was des Digga?
                        <span class="glyphicon glyphicon-info-sign pull-right" data-toggle="tooltip" data-placement="left" title="Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet."></span>
                    </div>
                    <canvas id="conversionRateChart" class="chart"></canvas>
                </div>
            </div>
        </div>

    </div>


    <?= GridView::widget([
        'dataProvider' => $provider,
        'tableOptions' => ['class' => 'hireMeTable footable toggle-arrow', 'id' => 'analyticsTable'],
        'columns'      => [
         [
                'label'  => 'Titel',
                'format' => 'raw',
                'value'  => function ($data) {
                    return \yii\helpers\Html::encode($data->title);
                }
            ],       
        [
                'label'  => 'Views',
                'format' => 'raw',
                'value'  => function ($data) {
                    return \yii\helpers\Html::encode(Analytics::getAllViewsAndClicksForJob($data->id)[0]);
                }
            ],    
        [
                'label'  => 'Clicks',
                'format' => 'raw',
                'value'  => function ($data) {
                    return \yii\helpers\Html::encode(Analytics::getAllViewsAndClicksForJob($data->id)[1]);
                }
        ],   
         [
                'label'  => 'Interest Rate',
                'format' => 'raw',
                'value'  => function ($data) {
                    return \yii\helpers\Html::encode(Analytics::getInterestRateForJob($data->id));
                }
        ],   
        [
                'label'  => 'Interview Rate',
                'format' => 'raw',
                'value'  => function ($data) {
                    return \yii\helpers\Html::encode(Analytics::getInterviewRateForJob($data->id));
                }
        ],   
        [
                'label'  => 'Application Rate',
                'format' => 'raw',
                'value'  => function ($data) {
                    return \yii\helpers\Html::encode(Analytics::getApplicationRateForJob($data->id));
                }
        ],   
        [
                'label'  => '',
                'format' => 'raw',
                'value'  => function ($data) {
                    return \yii\helpers\Html::a("Ansehen","/analytics/detail?id=".$data->id);
                }
        ],  
        ],
    ]); 

    ?>


</div>

