<?php

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\widgets\ListView;



$this->title = "Analytics für";

?>

<div class="myjobs">

    <h1><?= Html::encode($this->title) ?> <?= $companyName ?></h1>

    
    <p>


    <h1><?= $applyCount ?> Bewerbungen</h1>
    <h1><?= $hiredCount ?> Einstellungen</h1>
    <h1><?= $jobCount ?> Stellenanzeigen</h1>
    ---------------------------------------------------------------
    <h2><?= $clickCount  ?> Klicks bei <?= $viewCount ?> Views</h2>
    <h5>Interest Rate somit bei: <?= $interestRate ?> %</h5>
    <h2><?= $applyCount ?> Applications bei <?= $clickCount ?> Klicks</h2>
    <h5>Application Rate somit bei: <?= $applicationRate ?> %</h5>
    <h2>Interview Rate liegt bei: <?= $interviewRate ?> %</h2>
    <h2>Conversion Rate liegt bei: <?= $conversionRate ?> %</h2>
    </p>
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
