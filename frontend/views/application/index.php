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
use frontend\assets\ApplicationActionAsset;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\ApplicationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
ScoreAsset::register($this);
ApplicationActionAsset::register($this);
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
	<? if (!(Yii::$app->user->identity->isRecruiter())): ?>
	<div class="col-sm-12 searchBtn">
		<?= Html::a(Yii::t('app', 'Stellenanzeigen suchen'), ['/job'], ['class' => 'btn btn-success ripple']) ?>
	</div>
	<? endif; ?>
</div>
<div class="row">
	<div class="application-index">
		<div class="col-sm-12">
			
			<? /* Recruiter View */ ?>
			
			 <? if (Yii::$app->user->identity->isRecruiter()): ?>

			<?= GridView::widget([
				'dataProvider' => $provider,
				'tableOptions' => ['class' => 'hireMeTable footable toggle-arrow allowPrefill', 'id' => 'applicationsTable'],
				'columns'      => [
					[
		                'class'          => 'yii\grid\CheckboxColumn',
		                'headerOptions'  => ['class' => 'first-col'],
		                'contentOptions' => ['class' => 'first-col']
		            ],
					[
							'attribute' => 'fullName',
							'label' => 'Name',
							'format' => 'raw',
							'value'  => function ($data) {
								return Html::a(User::findOne($data["userID"])->getProfilePicture(true),'/application/view?id='.$data['id'])."".Html::a($data['fullName'],'/application/view?id='.$data['id']);
							},
							'headerOptions'  => ['class' => 'first-col'],
							'contentOptions' => ['class' => 'first-col'],
					], 
					
					[
							'attribute' => 'title',
							'label' => 'Stelle',
							'format' => 'raw',
							'headerOptions'  => ['class' => 'second-col','data-hide' => 'mediaXXsmall,phone'],
							'contentOptions' => ['class' => 'second-col'],
					], 
					 [
							'attribute' => 'score',
							'label' => 'Score',
							'format' => 'raw',
							'value'  => function ($data) {
								return Html::textinput($data['id'],Html::encode($data["score"]),['class' => 'scoreInput', 'id' => 'score_'.$data['id'],'name' => $data["id"]]);
							},
							'headerOptions'  => ['class' => 'third-col','data-hide' => 'mediaXXsmall,mediaXsmall,phone'],
							'contentOptions' => ['class' => 'third-col allowPrefill scoreInput'],
					],
					 [
							'attribute' => 'created_at',
							'label' => 'Beworben am',
							'format' => 'raw',
							'value'  => function ($data) {
								return Html::encode($data['created_at']);
							},
							'headerOptions'  => ['class' => 'fourth-col','data-hide' => 'mediaXXsmall,mediaXsmall,mediaSmall,phone'],
							'contentOptions' => ['class' => 'fourth-col'],
					], 
					[
							'label'  => '',
							'format' => 'raw',
							'value'  => function ($data) {
								return Html::a("<span class='glyphicon glyphicon-eye-open'></span>&nbsp;Ansehen",['/application/view?id='.$data['id']]);
							},
							'headerOptions'  => ['class' => 'fifth-col','data-hide' => 'mediaXXsmall,mediaXsmall,mediaSmall,phone'],
							'contentOptions' => ['class' => 'fifth-col'],
					],
					[
						'class'          => 'yii\grid\Column',
						'headerOptions'  => ['data-toggle' => 'true'],
						'contentOptions' => ['data-title' => 'data-toggle', 'class' => 'sixth-col']
					],
					[
						'attribute' => 'id',
						'label' => '',
						'format' => 'raw',
						'visible'=>false,
						'value'  => function ($data) {
								return Html::encode($data['id']);
						},
						'headerOptions'  => ['class' => 'seventh-col','data-hide' => 'mediaXXsmall,mediaXsmall,mediaSmall,phone'],
						'contentOptions' => ['class' => 'seventh-col appID hidden'],
					], 

				],

			]); ?>  
			<br>
			<? if ($provider->count > 0): ?>
		    <div class="dropdown" id="appAction" data-index="0">
		        <button id="dLabel" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
		                class="btn btn-success">
		            Aktion
		            <span class="caret"></span>
		        </button>
		        <ul class="dropdown-menu" aria-labelledby="dLabel">
		            <li class="action_archive">
		                <a href="#" tabindex="-1">Archivieren</a>
		            </li>
		            <li class="action_invite">
		                <a href="#" tabindex="-1">Zum Gespräch einladen</a>
		            </li>
		            <li class="action_hire">
		                <a href="#" tabindex="-1">Stelle besetzen</a>
		            </li>
		           <? if ($new == true): ?>
		           <li class="action_read">
		                <a href="#" tabindex="-1">Als gelesen markieren</a>
		            </li>
		           <? else: ?>
		            <li class="action_unread">
		                <a href="#" tabindex="-1">Als ungelesen markieren</a>
		            </li>
		           <? endif; ?>
		        </ul>
		    </div>
			<? endif; ?>
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
							return Job::getTitle($data['jobID']);
						},
						'headerOptions'  => ['class' => 'first-col'],
						'contentOptions' => ['class' => 'first-col']
					],

				[
						'label'  => 'Bewerbungsdatum',
						'format' => 'raw',
						'value'  => function ($data) {
							return Html::encode($data['created_at']);
						},
						'headerOptions'  => ['class' => 'second-col','data-hide' => 'xsmall,phone'],
						'contentOptions' => ['class' => 'second-col']
				],    
				  [
						'label'  => 'Status',
						'format' => 'raw',
						'value'  => function ($data) {
							return Html::encode($data['state']);
						},
						'headerOptions'  => ['class' => 'third-col','data-hide' => 'small,phone'],
						'contentOptions' => ['class' => 'third-col']
				],    
				[
						'label'  => '',
						'format' => 'raw',
						'value'  => function ($data) {
							return Html::a("<span class='glyphicon glyphicon-eye-open'></span>",'/application/view?id='.$data['id']);
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
			<? /* Bewerber View END*/ ?>
			<? endif; ?>

		</div>
	</div>


</div>