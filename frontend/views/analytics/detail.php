<?php

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\grid\GridView;
use frontend\models\Analytics;



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
