<?php

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\widgets\ListView;
use yii\grid\GridView;
use frontend\models\MyJobsGridView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Job */

$this->title = "Stellenanzeigen von " .$companyName;
$this->params['breadcrumbs'][] = ['label' => 'Jobs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="_myjobs">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
    <?=
    MyJobsGridView::widget([
    	'dataProvider' => $provider,
        'applierArray' => $applierArray,
        'columns' => [
        'title',
        'job_begin',
        ],
    	]);


    ?>
      
    </p>



</div>