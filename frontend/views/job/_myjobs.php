<?php

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Job */

$this->title = "Ausgeschriebene Jobs von " .$companyName;
$this->params['breadcrumbs'][] = ['label' => 'Jobs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="_myjobs">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
    <?=
    ListView::widget([
    	'dataProvider' => $provider,
    	'itemView' => function($model) {
    		return $model->description;
            
    	}
    	]);


    ?>
      
    </p>



</div>