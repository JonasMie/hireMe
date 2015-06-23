<?php

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\grid\GridView;
use frontend\models\Analytics;
use frontend\assets\CustomChartsAsset;

CustomChartsAsset::register($this);


$this->title = "Analytics: Detail";

?>

<div class="detail">
	<h1>Statistiken von "<?= $jobTitle ?>"</h1>
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
