<?php

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\widgets\ListView;



$this->title = "Analytics für";

?>

<div class="myjobs">

    <h1><?= Html::encode($this->title) ?> <?= $companyName ?></h1>



    <div class="row" id="analytics-tiles">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 analytics-tile analytics-tile-1 tile-black ripple" onclick="window.location='./bewerbungen';">
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
                    <div class="a-analytics">Einstellungen</div>
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




    <h2><?= $clickCount  ?> Klicks bei <?= $viewCount ?> Views</h2>
    <h5>Interest Rate somit bei: <?= $interestRate ?> %</h5>
    <h2><?= $applyCount ?> Applications bei <?= $clickCount ?> Klicks</h2>
    <h5>Application Rate somit bei: <?= $applicationRate ?> %</h5>
    <h2>Interview Rate liegt bei: <?= $interviewRate ?> %</h2>
    <h2>Conversion Rate liegt bei: <?= $conversionRate ?> %</h2>

    <h1>-------------------------------------------------------------------------------</h1>

     <?=
    ListView::widget([
        'dataProvider' => $provider,
        'itemView' =>function($model) {
            return $this->render('jobDetail',[
                'model' => $model,
            ]); 
        }
        ]);


    ?>


</div>

<!--<p>

    <h2><//?= $allJobs[0]->description ?></h2>
    <p>Anzahl Klicks overall: <//?= $clicks[0] ?></p>
    <p>Anzahl Bewerber auf diesen Job: <//?= $applicationsOverall[0] ?></p>

</p>
-->
