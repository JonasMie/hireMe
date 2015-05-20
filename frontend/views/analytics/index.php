<?php

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\widgets\ListView;



$this->title = "Analytics: Overview";
$this->params['breadcrumbs'][] = ['label' => 'Analytics', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="myjobs">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>

    <h1><?= $applyCount ?> Bewerbungen</h1>
    <h1><?= $hiredCount ?> Einstellungen</h1>
    <h1><?= $jobCount ?> Stellenanzeigen</h1>
    ---------------------------------------------------------------
    <h2><?= $clickCount  ?> Klicks bei <?= $viewCount ?> Views</h2>
    <h5>Interest Rate somit bei: <?= $interestRate ?> %</h5>
    <h2><?= $conversionRate ?>% Conversion Rate (Bewerbungen/Click)
    </p>



</div>

<!--<p>

    <h2><//?= $allJobs[0]->description ?></h2>
    <p>Anzahl Klicks overall: <//?= $clicks[0] ?></p>
    <p>Anzahl Bewerber auf diesen Job: <//?= $applicationsOverall[0] ?></p>

</p>
-->
