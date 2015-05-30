<?php

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\widgets\ListView;



$this->title = "Analytics: Detail";
$this->params['breadcrumbs'][] = ['label' => 'Analytics', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="detail">
	<h1>Detail Overview für: <?= $jobTitle ?></h1>
	<h2>View Count: <?= $viewCount ?></h2>
	<h2>Click Count: <?= $clickCount ?></h2>
	<h2>Interest Rate: <?= $interestRate ?> %</h2>
    <h2>Application Rate: <?= $applicationRate ?> %</h2>
	<h2>Interview Rate: <?= $interviewRate ?> %</h2>
	<h2>Bewerbungen: <?= $applyCount ?></h2>	
<h1>-----------------------</h1>
<h2>Analytics für Buttons:</h2>

 <?=
    ListView::widget([
    	'dataProvider' => $provider,
    	'itemView' =>function($model) {
    		return $this->render('btnDetail',[
    			'model' => $model,
    		]); 
    	}
    	]);


    ?>

<h4>


</div>
