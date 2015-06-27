<?php

use yii\helpers\Html;
use yii\grid\GridView;
use frontend\models\Application;
use frontend\controllers\ApplicationController;
use frontend\controllers\UserController;
use frontend\models\Job;
use yii\widgets\ListView;
use common\models\User;
use frontend\assets\ScoreAsset;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\ApplicationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
ScoreAsset::register($this);
$this->title = 'Bewerbungen';
?>

<!-- Initializing Foo Tables -->
<? $this->registerJS(
    "$(function () {
        $('.footable').footable({
            breakpoints: {
                /* Somehow Footable misses the screen wdtdh by 31 Pixels */
                mediaXXsmall: 480,
                mediaXsmall: 736,
                mediaSmall: 960

            }
        });
    });");

?>

<div class="row">
	<div class="col-sm-12">
		<h1><?= Html::encode($this->title) ?></h1>
	</div>
	<div class="col-sm-12 searchBtn">
		<?= Html::a(Yii::t('app', 'Stellenanzeigen suchen'), ['/job'], ['class' => 'btn btn-success ripple']) ?>
	</div>
</div>
<div class="row">
	<div class="application-index">
		<div class="col-sm-12">
			
			<? /* Recruiter View */ ?>
			
			 <? if (Yii::$app->user->identity->isRecruiter()): ?>
			   
				 <h1><?= Html::encode($title) ?></h1>

			<?= GridView::widget([
				'dataProvider' => $provider,
				'tableOptions' => ['class' => 'hireMeTable footable toggle-arrow allowPrefill', 'id' => 'applicationTable'],
				'columns'      => [
					[
							'attribute' => 'fullName',
							'label' => 'Name',
							'format' => 'raw',
							'value'  => function ($data) {
								return User::findOne($data["userID"])->getProfilePicture(true)."".Html::a($data['fullName'],'/user?un='.$data['userName']);
							},
							'headerOptions'  => ['class' => 'first-col'],
							'contentOptions' => ['class' => 'first-col'],
					], 

					 'title:text:Stelle',
					 [
							'attribute' => 'score',
							'label' => 'Score',
							'format' => 'raw',
							'value'  => function ($data) {
								return Html::textinput($data['id'],Html::encode($data["score"]),['id' => 'scoreInput','name' => $data["id"]]);
							},
							'contentOptions' => ['class' => 'allowPrefill'],
					],
					 [
							'attribute' => 'created_at',
							'label' => 'Beworben am',
							'format' => 'raw',
							'value'  => function ($data) {
								return Html::encode($data['created_at']);
							},
							'headerOptions'  => ['class' => 'second-col'],
							'contentOptions' => ['class' => 'second-col'],
					], 
					[
							'label'  => '',
							'format' => 'raw',
							'value'  => function ($data) {
								return Html::a("Ansehen",['/application/view?id='.$data['id']]);
							},
							'headerOptions'  => ['class' => 'third-col','data-hide' => 'xsmall,phone'],
							'contentOptions' => ['class' => 'third-col'],
					],
					[
						'class'          => 'yii\grid\Column',
						'headerOptions'  => ['data-toggle' => 'true'],
						'contentOptions' => ['data-title' => 'data-toggle', 'class' => 'fifth-col']
					],
				],

			]); ?>  
			<? /* Recruiter View End */ ?>
			
			<? /* Bewerber View */ ?>
			  <? else:?>

			 <h2><?= Html::encode("Gespeicherte Bewerbungen") ?></h2>

			 <?= GridView::widget([
				'dataProvider' => $savedProvider,
				'tableOptions' => ['class' => 'hireMeTable footable toggle-arrow', 'id' => 'applicationTable'],
				'columns'      => [
					 [
							'label'  => 'Stellenanzeige',
							'format' => 'raw',
							'value'  => function ($data) {
								return Html::a(Job::getTitle($data->job_id),"/application/add-data?id=".$data->id);
							},
							'headerOptions'  => ['class' => 'first-col'],
							'contentOptions' => ['class' => 'first-col']
						],

					[
							'label'  => 'Erstellt',
							'format' => 'raw',
							'value'  => function ($data) {
								return Html::encode($data->created_at);
							},
							'headerOptions'  => ['class' => 'second-col','data-hide' => 'xsmall,phone'],
							'contentOptions' => ['class' => 'second-col']
					],    
					[
							'label'  => '',
							'format' => 'raw',
							'value'  => function ($data) {
								return Html::a("<span class='glyphicon glyphicon-pencil'></span>&nbsp;&nbsp;Bearbeiten",'/application/add-data?id='.$data->id,['class' => 'btn btn-success ripple']);
							},
							'headerOptions'  => ['class' => 'third-col'],
							'contentOptions' => ['class' => 'third-col']
					],
					[
						'class'          => 'yii\grid\Column',
						'headerOptions'  => ['data-toggle' => 'true'],
						'contentOptions' => ['data-title' => 'data-toggle', 'class' => 'fourth-col']
					],			
				],

			]); ?>  
			 <h2><?= Html::encode("Gesendete Bewerbungen") ?></h2>

			<?= GridView::widget([
				'dataProvider' => $sentProvider,
				'tableOptions' => ['class' => 'hireMeTable footable toggle-arrow', 'id' => 'applicationTable'],
				'columns'      => [
				 [
						'label'  => 'Stellenanzeige',
						'format' => 'raw',
						'value'  => function ($data) {
							return Job::getTitle($data->job_id);
						},
						'headerOptions'  => ['class' => 'first-col'],
						'contentOptions' => ['class' => 'first-col']
					],

				[
						'label'  => 'Bewerbungsdatum',
						'format' => 'raw',
						'value'  => function ($data) {
							return Html::encode($data->created_at);
						},
						'headerOptions'  => ['class' => 'second-col','data-hide' => 'xsmall,phone'],
						'contentOptions' => ['class' => 'second-col']
				],    
				  [
						'label'  => 'Status',
						'format' => 'raw',
						'value'  => function ($data) {
							return Html::encode($data->state);
						},
						'headerOptions'  => ['class' => 'third-col','data-hide' => 'small,phone'],
						'contentOptions' => ['class' => 'third-col']
				],    
				[
						'label'  => '',
						'format' => 'raw',
						'value'  => function ($data) {
							return Html::a("<span class='glyphicon glyphicon-eye-open'></span>",'/application/view?id='.$data->id);
						},
						'headerOptions'  => ['class' => 'fourth-col'],
						'contentOptions' => ['class' => 'fourth-col'],
				],
				[
					'class'          => 'yii\grid\Column',
					'headerOptions'  => ['data-toggle' => 'true'],
					'contentOptions' => ['data-title' => 'data-toggle', 'class' => 'fifth-col']
				],
				],

			]); ?>
			
			<? endif; ?>

		</div>
	</div>


</div>