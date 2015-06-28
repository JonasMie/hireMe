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

<!-- Initializing Foo Tables -->
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

<div class="myjobs">

    <h1><?= Html::encode($this->title) ?> <?= $companyName ?></h1>

    <div class="row" id="analytics-tiles">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 analytics-tile analytics-tile-1 tile-black ripple"
             onclick="window.location='./application';">
            <div class="subtile subtile-left">
                <div class="tile-value tile-number">
                    <?= Html::a($applyCount, "/bewerbungen"); ?>
                </div>
                <div class="tile-value tile-string">
                    <?= Html::a('Bewerbungen insgesamt', "/bewerbungen"); ?>
                </div>
            </div>
            <div class="subtile subtile-right">

            </div>
        </div>

        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 analytics-tile analytics-tile-2 tile-green ripple">
            <div class="subtile subtile-left">
                <div class="tile-value tile-number">
                    <div class="a-analytics"><?= $hiredCount ?></div>
                </div>
                <div class="tile-value tile-string">
                    <div class="a-analytics">Neue Mitarbeiter</div>
                </div>
            </div>
            <div class="subtile subtile-right">

            </div>
        </div>

        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 analytics-tile analytics-tile-3 tile-black ripple"
             onclick="window.location='./job';">
            <div class="subtile subtile-left">
                <div class="tile-value tile-number">
                    <?= Html::a($jobCount, "/job"); ?>
                </div>
                <div class="tile-value tile-string">
                    <?= Html::a('Stellenanzeigen', "/job"); ?>
                </div>
            </div>
            <div class="subtile subtile-right">

            </div>
        </div>

    </div>


    <!-- CHARTS -->

    <div id="analyticsCharts">

        <div id="charts-first-row" class="row">
            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 chartTile first-col">
                <div class="background-wrapper">
                    <div class="header">
                        Views und Clicks
                        <span class="glyphicon glyphicon-info-sign pull-right" data-toggle="tooltip"
                              data-placement="left"
                              title="Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet."></span>
                    </div>
                    <div id="viewClickIsNull" class="no-chart-data no-chart-data-row-1-col-1">Keine Daten verfügbar</div>
                    <canvas id="viewClickChart" class="chart"></canvas>
                </div>
            </div>

            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 chartTile second-col">
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

            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 chartTile third-col">
                <div class="background-wrapper">
                    <div class="header">
                        Clicks und Bewerbungen
                        <span class="glyphicon glyphicon-info-sign pull-right" data-toggle="tooltip"
                              data-placement="left"
                              title="Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet."></span>
                    </div>
                    <div id="clickApplyIsNull" class="no-chart-data no-chart-data-row-1-col-2">Keine Daten verfügbar</div>
                    <canvas id="clicksApplicationChart" class="chart"></canvas>
                </div>
            </div>

            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 chartTile fourth-col">
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


        <div id="charts-second-row" class="row">
            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 chartTile first-col">
                <div class="background-wrapper">
                    <div class="header">
                        Bewerbungen und Interviews
                        <span class="glyphicon glyphicon-info-sign pull-right" data-toggle="tooltip"
                              data-placement="left"
                              title="Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet."></span>
                    </div>
                    <div id="interviewApplyIsNull" class="no-chart-data no-chart-data-row-2-col-1">Keine Daten verfügbar</div>
                    <canvas id="interviewApplicationChart" class="chart"></canvas>
                </div>
            </div>

            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 chartTile second-col">
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

            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 chartTile third-col">
                <div class="background-wrapper">
                    <div class="header">
                        Was des Digga?
                        <span class="glyphicon glyphicon-info-sign pull-right" data-toggle="tooltip"
                              data-placement="left"
                              title="Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet."></span>
                    </div>
                    <div id="applyHiredIsNull" class="no-chart-data no-chart-data-row-2-col-2">Keine Daten verfügbar</div>
                    <canvas id="applicationHiredChart" class="chart"></canvas>
                </div>
            </div>

            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 chartTile fourth-col">
                <div class="background-wrapper">
                    <div class="header">
                        Was des Digga?
                        <span class="glyphicon glyphicon-info-sign pull-right" data-toggle="tooltip"
                              data-placement="left"
                              title="Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet."></span>
                    </div>
                    <canvas id="conversionRateChart" class="chart"></canvas>
                </div>
            </div>
        </div>

    </div>

    <h2 class="detailHeader">Detaillierte Ansicht pro Stellenanzeige</h2>

    <?= GridView::widget([
        'dataProvider' => $provider,
        'tableOptions' => ['class' => 'hireMeTable footable toggle-arrow', 'id' => 'analyticsTable'],
        'columns' => [
            [
                'label' => 'Titel',
                'format' => 'raw',
                'headerOptions' => ['class' => 'first-col', 'data-hide' => ''],
                'contentOptions' => ['class' => 'first-col'],
                'value' => function ($data) {
                    return \yii\helpers\Html::encode($data['title']);
                }
            ],
            [
                'label' => 'Views',
                'format' => 'raw',
                'headerOptions' => ['class' => 'second-col', 'data-hide' => 'phone,mediaXXsmall,mediaXsmall'],
                'contentOptions' => ['class' => 'second-col'],
                'value' => function ($data) {
                    if ($data['views'] == 0) {
                        return \yii\helpers\Html::encode("0");
                    }
                    return \yii\helpers\Html::encode($data['views']);
                }
            ],
            [
                'label' => 'Clicks',
                'format' => 'raw',
                'headerOptions' => ['class' => 'third-col', 'data-hide' => 'phone,mediaXXsmall,mediaXsmall'],
                'contentOptions' => ['class' => 'third-col'],
                'value' => function ($data) {
                    if ($data['clicks'] == 0) {
                        return \yii\helpers\Html::encode("0");
                    }
                    return \yii\helpers\Html::encode($data['clicks']);
                }
            ],
            [
                'label' => 'Bewerber',
                'format' => 'raw',
                'headerOptions' => ['class' => 'fourth-col', 'data-hide' => 'mediaXXsmall,phone'],
                'contentOptions' => ['class' => 'fourth-col'],
                'value' => function ($data) {
                    return \yii\helpers\Html::encode(Analytics::getAppliesForJob($data['id']));
                }
            ],
            [
                'label' => 'InterestRate',
                'format' => 'raw',
                'headerOptions' => ['class' => 'fifth-col', 'data-hide' => 'phone,mediaXXsmall,mediaXsmall,mediaSmall'],
                'contentOptions' => ['class' => 'fifth-col'],
                'value' => function ($data) {
                    if ($data['interestRate'] == null) {
                        return \yii\helpers\Html::encode("0 %");
                    }
                    return \yii\helpers\Html::encode($data['interestRate'] . " %");
                }
            ],
            [
                'label' => 'ApplicationRate',
                'format' => 'raw',
                'headerOptions' => ['class' => 'sixth-col', 'data-hide' => 'phone,mediaXXsmall,mediaXsmall,mediaSmall'],
                'contentOptions' => ['class' => 'sixth-col'],
                'value' => function ($data) {
                    if ($data['clicks'] == 0) {
                        return \yii\helpers\Html::encode("0 %");
                    }
                    return \yii\helpers\Html::encode(round(100 * Analytics::getAppliesForJob($data['id']) / $data['clicks'], 2) . " %");
                }
            ],
            [
                'label' => 'InterviewRate',
                'format' => 'raw',
                'headerOptions' => ['class' => 'seventh-col', 'data-hide' => 'phone,mediaXXsmall,mediaXsmall,mediaSmall'],
                'contentOptions' => ['class' => 'seventh-col'],
                'value' => function ($data) {
                    $interviews = Analytics::getInterviewsForJob($data['id']);
                    if ($interviews == 0) {
                        return \yii\helpers\Html::encode("0 %");
                    }
                    return \yii\helpers\Html::encode(round(100 * Analytics::getInterviewsForJob($data['id']) / Analytics::getAppliesForJob($data['id']), 2) . " %");
                }
            ],
            [
                'label' => 'Ansehen',
                'format' => 'raw',
                'headerOptions' => ['class' => 'eight-col', 'data-hide' => ''],
                'contentOptions' => ['class' => 'eight-col'],
                'value' => function ($data) {
                    return \yii\helpers\Html::a("<span class='glyphicon glyphicon-eye-open'></span>", "/analytics/detail?id=" . $data['id']);
                }
            ],
            [

                'class' => 'yii\grid\Column',
                'headerOptions' => ['data-toggle' => 'true'],
                'contentOptions' => ['data-title' => 'data-toggle', 'class' => 'ninth-col']

            ],
        ],
    ]);

    ?>


    <div id="charts-third-row" class="row">
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 chartTile first-col">
            <div class="background-wrapper">
                <div class="header">
                    Views im Vergleich
                        <span class="glyphicon glyphicon-info-sign pull-right" data-toggle="tooltip"
                              data-placement="left"
                              title="Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet."></span>
                </div>
                <div id="viewComparisonIsNull" class="no-chart-data no-chart-data-row-3-col-1">Keine Daten verfügbar</div>
                <canvas id="viewCompareChart" class="chart"></canvas>
            </div>
        </div>

        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 chartTile second-col">
            <div class="background-wrapper">
                <div class="header">
                    Clicks im Vergleich
                        <span class="glyphicon glyphicon-info-sign pull-right" data-toggle="tooltip"
                              data-placement="left"
                              title="Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet."></span>
                </div>
                 <div id="clickComparisonIsNull" class="no-chart-data no-chart-data-row-3-col-2">Keine Daten verfügbar</div>
                <canvas id="clickCompareChart" class="chart"></canvas>
            </div>
        </div>
    </div>



</div>

