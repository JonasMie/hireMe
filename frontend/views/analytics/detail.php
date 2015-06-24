<?php

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\grid\GridView;
use frontend\models\Analytics;
use frontend\assets\DetailChartsAsset;

DetailChartsAsset::register($this);


$this->title = "Analytics: Detail";

?>

<? $this->registerJS(
    "$(function () {
        $('.footable').footable({
            breakpoints: {
                /* Somehow Footable misses the screen width by 31 Pixels */
                mediaXXsmall: 480,
                mediaXsmall: 736,
                mediaSmall: 960

            }
        });
    });");
?>

<div class="detail">
	<h1>Statistiken von "<?= $jobTitle ?>"</h1>
    <p class="hidden" id="hiddenID"><?= $jobID ?></p>
<!-- FIRST ROW BEGIN-->

    <div class="row" id="analytics-tiles">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 analytics-tile analytics-tile-1 tile-black ripple">
            <div class="subtile subtile-left">
                <div class="tile-value tile-number">
                    <?= Html::a($viewCount, "/#"); ?>
                </div>
                <div class="tile-value tile-string">
                    <?= Html::a('Views', "/#"); ?>
                </div>
            </div>
            <div class="subtile subtile-right hidden-xs">

            </div>
        </div>

        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 analytics-tile analytics-tile-2 tile-green ripple">
            <div class="subtile subtile-left">
                <div class="tile-value tile-number">
                    <div class="a-analytics"><?=$clickCount?></div>
                </div>
                <div class="tile-value tile-string">
                    <div class="a-analytics">Clicks</div>
                </div>
            </div>
            <div class="subtile subtile-right hidden-xs">

            </div>
        </div>

        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 analytics-tile analytics-tile-3 tile-black ripple" onclick="window.location='./job';">
            <div class="subtile subtile-left">
                <div class="tile-value tile-number">
                    <?= Html::a($applyCount, "/#"); ?>
                </div>
                <div class="tile-value tile-string">
                    <?= Html::a('Bewerber', "/#"); ?>
                </div>
            </div>
            <div class="subtile subtile-right hidden-xs">

            </div>
        </div>

    </div>
<!-- FIRST ROW END-->
<!-- SECOND ROW BEGIN-->


 <div class="row" id="analytics-tiles">
 
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 analytics-tile analytics-tile-2 tile-green ripple">
            <div class="subtile subtile-left">
                <div class="tile-value tile-number">
                    <div class="a-analytics"><?=$interestRate?> %</div>
                </div>
                <div class="tile-value tile-string">
                    <div class="a-analytics">Interest Rate</div>
                </div>
            </div>
            <div class="subtile subtile-right hidden-xs">

            </div>
        </div>

        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 analytics-tile analytics-tile-2 tile-green ripple">
            <div class="subtile subtile-left">
                <div class="tile-value tile-number">
                    <div class="a-analytics"><?=$applicationRate?> %</div>
                </div>
                <div class="tile-value tile-string">
                    <div class="a-analytics">Application Rate</div>
                </div>
            </div>
            <div class="subtile subtile-right hidden-xs">

            </div>
        </div>
        
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 analytics-tile analytics-tile-2 tile-green ripple">
            <div class="subtile subtile-left">
                <div class="tile-value tile-number">
                    <div class="a-analytics"><?=$interviewRate?> %</div>
                </div>
                <div class="tile-value tile-string">
                    <div class="a-analytics">Interview Rate</div>
                </div>
            </div>
            <div class="subtile subtile-right hidden-xs">

            </div>
        </div>

    </div>
<!-- SECOND ROW END-->


 <div id="analyticsCharts">

        <div id="charts-first-row" class="row">
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 chartTile first-col">
                <div class="background-wrapper">
                    <div class="header">
                        Views und Clicks
                        <span class="glyphicon glyphicon-info-sign pull-right" data-toggle="tooltip"
                              data-placement="left"
                              title="Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet."></span>
                    </div>
                    <canvas id="viewClickChart" class="chart"></canvas>
                </div>
            </div>

            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 chartTile second-col">
                <div class="background-wrapper">
                    <div class="header">
                        Interesst Rate
                        <span class="glyphicon glyphicon-info-sign pull-right" data-toggle="tooltip"
                              data-placement="left"
                              title="Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet."></span>
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
                        <span class="glyphicon glyphicon-info-sign pull-right" data-toggle="tooltip"
                              data-placement="left"
                              title="Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet."></span>
                    </div>
                    <canvas id="clicksApplicationChart" class="chart"></canvas>
                </div>
            </div>

            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 chartTile second-col">
                <div class="background-wrapper">
                    <div class="header">
                        Application Rate
                        <span class="glyphicon glyphicon-info-sign pull-right" data-toggle="tooltip"
                              data-placement="left"
                              title="Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet."></span>
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
                        <span class="glyphicon glyphicon-info-sign pull-right" data-toggle="tooltip"
                              data-placement="left"
                              title="Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet."></span>
                    </div>
                    <canvas id="interviewApplicationChart" class="chart"></canvas>
                </div>
            </div>

            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 chartTile second-col">
                <div class="background-wrapper">
                    <div class="header">
                        Interview Rate
                        <span class="glyphicon glyphicon-info-sign pull-right" data-toggle="tooltip"
                              data-placement="left"
                              title="Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet."></span>
                    </div>
                    <canvas id="interviewRateChart" class="chart"></canvas>
                </div>
            </div>
        </div>
    </div>


<h2>Buttons:</h2>


 <?= GridView::widget([
        'dataProvider' => $provider,
        'columns'      => [
         [
                'label'  => 'Seite',
                'format' => 'raw',
                'value'  => function ($data) {
                    return \yii\helpers\Html::encode($data->site);
                }
            ],       
        [
                'label'  => 'Key',
                'format' => 'raw',
                'value'  => function ($data) {
                    return \yii\helpers\Html::encode($data->key);
                }
            ],    
        [
                'label'  => 'Views',
                'format' => 'raw',
                'value'  => function ($data) {
                    return \yii\helpers\Html::encode($data->viewCount);
                }
            ],   
        [
                'label'  => 'Clicks',
                'format' => 'raw',
                'value'  => function ($data) {
                    return \yii\helpers\Html::encode($data->clickCount);
                }
            ], 
        [
                'label'  => 'Interest Rate',
                'format' => 'raw',
                'value'  => function ($data) {
                    return \yii\helpers\Html::encode(Analytics::getInterestRateForBtn($data->id)." %");
                }
            ],     
         [
                'label'  => 'Interview Rate',
                'format' => 'raw',
                'value'  => function ($data) {
                    return \yii\helpers\Html::encode(Analytics::getInterviewRateForBtn($data->id)." %");
                }
            ],
         [
                'label'  => 'Application Rate',
                'format' => 'raw',
                'value'  => function ($data) {
                    return \yii\helpers\Html::encode(Analytics::getApplicationRateForBtn($data->id)." %");
                }
            ],

        ],
    ]); ?>  


<h4>


</div>
