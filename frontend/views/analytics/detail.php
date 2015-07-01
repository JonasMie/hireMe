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
            <div class="subtile subtile-right ">

            </div>
        </div>

        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 analytics-tile analytics-tile-2 tile-green ripple">
            <div class="subtile subtile-left">
                <div class="tile-value tile-number">
                    <div class="a-analytics"><?= $clickCount ?></div>
                </div>
                <div class="tile-value tile-string">
                    <div class="a-analytics">Clicks</div>
                </div>
            </div>
            <div class="subtile subtile-right ">

            </div>
        </div>

        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 analytics-tile analytics-tile-3 tile-black ripple"
             onclick="window.location='./job';">
            <div class="subtile subtile-left">
                <div class="tile-value tile-number">
                    <?= Html::a($applyCount, "/#"); ?>
                </div>
                <div class="tile-value tile-string">
                    <?= Html::a('Bewerber', "/#"); ?>
                </div>
            </div>
            <div class="subtile subtile-right ">

            </div>
        </div>

    </div>
    <!-- FIRST ROW END-->
    <!-- SECOND ROW BEGIN-->

    <div class="row" id="analytics-tiles">

        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 analytics-tile analytics-tile-4 tile-green ripple">
            <div class="subtile subtile-left">
                <div class="tile-value tile-number">
                    <div class="a-analytics"><?= $interestRate ?> %</div>
                </div>
                <div class="tile-value tile-string">
                    <div class="a-analytics">Interest Rate</div>
                </div>
            </div>
            <div class="subtile subtile-right ">

            </div>
        </div>

        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 analytics-tile analytics-tile-5 tile-black ripple">
            <div class="subtile subtile-left">
                <div class="tile-value tile-number">
                    <div class="a-analytics"><?= $applicationRate ?> %</div>
                </div>
                <div class="tile-value tile-string">
                    <div class="a-analytics">Application Rate</div>
                </div>
            </div>
            <div class="subtile subtile-right ">

            </div>
        </div>

        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 analytics-tile analytics-tile-6 tile-green ripple">
            <div class="subtile subtile-left">
                <div class="tile-value tile-number">
                    <div class="a-analytics"><?= $interviewRate ?> %</div>
                </div>
                <div class="tile-value tile-string">
                    <div class="a-analytics">Interview Rate</div>
                </div>
            </div>
            <div class="subtile subtile-right ">

            </div>
        </div>

    </div>
    <!-- SECOND ROW END-->


    <div id="analyticsCharts">

        <div id="charts-first-row" class="row">
            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 chartTile first-col">
                <div class="background-wrapper">
                    <div class="header">
                        Interest
                        <span class="glyphicon glyphicon-info-sign pull-right" data-toggle="tooltip"
                              data-placement="left"
                              title="Die Anzahl der Leute, die einen Button dieser Stellenanzeige gesehen haben, sowie die Anzahl derer, die darauf geklickt haben."></span>
                    </div>
                    <div id="isNull" class="no-chart-data no-chart-data-row-1-col-1">Noch keine Daten verfügbar</div>
                    <canvas id="viewClickChart" class="chart"></canvas>
                </div>
            </div>

            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 chartTile second-col">
                <div class="background-wrapper">
                    <div class="header">
                        Interesst Rate
                        <span class="glyphicon glyphicon-info-sign pull-right" data-toggle="tooltip"
                              data-placement="left"
                              title="Beschreibt prozentual den Anteil der Leute, die auf einen Button geklickt haben zu denen, die sie insgesamt gesehen haben. "></span>
                    </div>
                    <div id="isNull" class="no-chart-data no-chart-data-row-1-col-1">Noch keine Daten verfügbar</div>
                    <canvas id="interestRateChart" class="chart"></canvas>
                </div>
            </div>

            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 chartTile third-col">
                <div class="background-wrapper">
                    <div class="header">
                        Applications
                        <span class="glyphicon glyphicon-info-sign pull-right" data-toggle="tooltip"
                              data-placement="left"
                              title="Zeigt die Klicks auf einen der Buttons, sowie die daraus ergangenen Bewerbungen"></span>
                    </div>
                    <div id="isNull" class="no-chart-data no-chart-data-row-1-col-1">Noch keine Daten verfügbar</div>
                    <canvas id="clicksApplicationChart" class="chart"></canvas>
                </div>
            </div>

            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 chartTile fourth-col">
                <div class="background-wrapper">
                    <div class="header">
                        Application Rate
                        <span class="glyphicon glyphicon-info-sign pull-right" data-toggle="tooltip"
                              data-placement="left"
                              title="Anteil derer, die sich beworben haben, zu denen die auf einen Button klickten."></span>
                    </div>
                    <div id="isNull" class="no-chart-data no-chart-data-row-1-col-1">Noch keine Daten verfügbar</div>
                    <canvas id="applicationRateChart" class="chart"></canvas>
                </div>
            </div>
        </div>

        <div id="charts-second-row" class="row">
            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 chartTile first-col">
                <div class="background-wrapper">
                    <div class="header">
                        Interviews
                        <span class="glyphicon glyphicon-info-sign pull-right" data-toggle="tooltip"
                              data-placement="left"
                              title="Bewerbungen auf diese Stellenanzeige, sowie Bewerbungen, bei denen es zu einem persönlichen Gespräch kam."></span>
                    </div>
                    <div id="isNull" class="no-chart-data no-chart-data-row-1-col-1">Noch keine Daten verfügbar</div>
                    <canvas id="interviewApplicationChart" class="chart"></canvas>
                </div>
            </div>

            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 chartTile second-col">
                <div class="background-wrapper">
                    <div class="header">
                        Interview Rate
                        <span class="glyphicon glyphicon-info-sign pull-right" data-toggle="tooltip"
                              data-placement="left"
                              title="Anteil an persönlichen Gesprächen, gemessen an den Bewerbern."></span>
                    </div>
                    <div id="isNull" class="no-chart-data no-chart-data-row-1-col-1">Noch keine Daten verfügbar</div>
                    <canvas id="interviewRateChart" class="chart"></canvas>
                </div>
            </div>

            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 chartTile third-col">
                <div class="background-wrapper">
                    <div class="header">
                        Button View Rate
                        <span class="glyphicon glyphicon-info-sign pull-right" data-toggle="tooltip"
                              data-placement="left"
                              title="Die Views der einzelnen Buttons für diese Stellenanzeige prozentual im Überblick"></span>
                    </div>
                    <div id="isNull" class="no-chart-data no-chart-data-row-1-col-1">Noch keine Daten verfügbar</div>
                    <canvas id="viewCompareChart" class="chart"></canvas>
                </div>
            </div>

            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 chartTile fourth-col">
                <div class="background-wrapper">
                    <div class="header">
                        Button Klick Rate
                        <span class="glyphicon glyphicon-info-sign pull-right" data-toggle="tooltip"
                              data-placement="left"
                              title="Die Klicks der einzelnen Buttons für diese Stellenanzeige prozentual im Überblick"></span>
                    </div>
                    <div id="isNull" class="no-chart-data no-chart-data-row-1-col-1">Noch keine Daten verfügbar</div>
                    <canvas id="clickCompareChart" class="chart"></canvas>
                </div>
            </div>
        </div>
    </div>


    <h2>Button Statistiken im Detail</h2>


    <?= GridView::widget([
        'dataProvider' => $provider,
        'tableOptions' => ['class' => 'hireMeTable footable toggle-arrow', 'id' => 'analyticsTable'],
        'columns' => [
            [
                'label' => 'Seite',
                'format' => 'raw',
                'headerOptions' => ['class' => 'first-col', 'data-hide' => ''],
                'contentOptions' => ['class' => 'first-col'],
                'value' => function ($data) {
					if ($data->archived == 1) {
						return \yii\helpers\Html::encode($data->site) . ' <span class="text-danger"><span class="glyphicon glyphicon-ban-circle" title="archiviert" alt="archiviert"></span></span>';
					}
					else {
						return \yii\helpers\Html::encode($data->site);
					}
                }
            ],
            [
                'label' => 'Key',
                'format' => 'raw',
                'headerOptions' => ['class' => 'second-col', 'data-hide' => 'phone,mediaXXsmall,mediaXsmall'],
                'contentOptions' => ['class' => 'second-col'],
                'value' => function ($data) {
                    return \yii\helpers\Html::encode($data->key);
                }
            ],
            [
                'label' => 'Views',
                'format' => 'raw',
                'headerOptions' => ['class' => 'third-col', 'data-hide' => 'mediaXXsmall,phone'],
                'contentOptions' => ['class' => 'third-col'],
                'value' => function ($data) {
                    return \yii\helpers\Html::encode($data->viewCount);
                }
            ],
            [
                'label' => 'Clicks',
                'format' => 'raw',
                'headerOptions' => ['class' => 'fourth-col', 'data-hide' => 'mediaXXsmall,phone'],
                'contentOptions' => ['class' => 'fourth-col'],
                'value' => function ($data) {
                    return \yii\helpers\Html::encode($data->clickCount);
                }
            ],
            [
                'label' => 'Interest Rate',
                'format' => 'raw',
                'headerOptions' => ['class' => 'fifth-col', 'data-hide' => 'phone,mediaXXsmall,mediaXsmall,mediaSmall'],
                'contentOptions' => ['class' => 'fifth-col'],
                'value' => function ($data) {
                    return \yii\helpers\Html::encode(Analytics::getInterestRateForBtn($data->id) . " %");
                }
            ],
            [
                'label' => 'Interview Rate',
                'format' => 'raw',
                'headerOptions' => ['class' => 'sixth-col', 'data-hide' => 'phone,mediaXXsmall,mediaXsmall,mediaSmall'],
                'contentOptions' => ['class' => 'sixth-col'],
                'value' => function ($data) {
                    return \yii\helpers\Html::encode(Analytics::getInterviewRateForBtn($data->id) . " %");
                }
            ],
            [
                'label' => 'Application Rate',
                'format' => 'raw',
                'headerOptions' => ['class' => 'seventh-col', 'data-hide' => 'phone,mediaXXsmall,mediaXsmall,mediaSmall'],
                'contentOptions' => ['class' => 'seventh-col'],
                'value' => function ($data) {
                    return \yii\helpers\Html::encode(Analytics::getApplicationRateForBtn($data->id) . " %");
                }
            ],
            [

                'class' => 'yii\grid\Column',
                'headerOptions' => ['data-toggle' => 'true'],
                'contentOptions' => ['data-title' => 'data-toggle', 'class' => 'ninth-col']

            ],

        ],
    ]); ?>


    <h4>


</div>
