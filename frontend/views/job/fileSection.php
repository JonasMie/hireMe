<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use frontend\models\ApplicationData;
use yii\widgets\ActiveForm;

?>

<h2>Anlagen</h2>

 <?= GridView::widget([
		'dataProvider' => $provider,
		'tableOptions' => ['class' => 'hireMeTable footable toggle-arrow', 'id' => 'applicationTable'],
		'columns'      => [
	   [
			'label'  => 'Titel',
			'format' => 'raw',
			'value'  => 'title',
			'headerOptions'  => ['class' => 'first-col'],
			'contentOptions' => ['class' => 'first-col'],
		], 
		[
			'label'  => '',
			'format' => 'raw',
			'value'  => function ($data) {   
						return  Html::button("<span class='glyphicon glyphicon-floppy-open'></span>&nbsp;&nbsp;Anhängen",['id' => 'addAttachement'.$data['id'],'onclick'=>'js:addData('.$data['id'].');','class'=>'btn btn-success']);
				},
			'headerOptions'  => ['class' => 'second-col'],
			'contentOptions' => ['class' => 'second-col'],    
		], 
	   [
			'label'  => '',
			'format' => 'raw',
			'value'  => function ($data) {
				return  Html::a("<span class='glyphicon glyphicon-eye-open'></span>&nbsp;Ansehen","/application/show-file?id=".$data['id'],['target' => '_blank']);
				},
			'headerOptions'  => ['class' => 'third-col'],
			'contentOptions' => ['class' => 'third-col'],
		], 
		[
			'label'  => '',
			'format' => 'raw',
			'value'  => function ($data) {
				return  Html::label("",null,['id' => "show_".$data['id']]);
				},
			'headerOptions'  => ['class' => 'fourth-col'],
			'contentOptions' => ['class' => 'fourth-col'],
		], 
			],

	]);
?>  


