<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use frontend\models\Application;
use yii\grid\GridView;
use frontend\controllers\ApplicationController;
use frontend\models\ResumeJob;
use frontend\models\ResumeSchool;
use frontend\models\Company;
use frontend\assets\ScoreAsset;
/* @var $this yii\web\View */
/* @var $model frontend\models\Application */
/* @var $currentSchoolsDataProvider \yii\data\ActiveDataProvider */
/* @var $currentJobsDataProvider \yii\data\ActiveDataProvider */
ScoreAsset::register($this);

if (Yii::$app->user->identity->isRecruiter()){
	$this->title = 'Bewerbung von '.$model["user"]->fullName;
}

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

<div class="application-view">
	
	<? /* View as Recruiter */ ?>

    <? if (Yii::$app->user->identity->isRecruiter()): ?>
    <?
        $model["app"]->read = 1;
        $model["app"]->save();
    ?>
	<div class="row">
		<div class="col-sm-12">
			<h1>Bewerbung von <?= $model["user"]->fullName .' als '.Html::a($model['job']->title,"/job/view?id=".$model['job']->id); ?></h1>
		</div>
	</div>
	
	<div class="row first">
	
		<div class="col-sm-4 profileInfo">
		
			<div class="row">
			
				<div class="col-sm-12">
				
					<?= $model["user"]->getProfilePicture() ?>
				
				</div>
				
				<div class="col-sm-12">
					<h2>Score</h2>
					<div class="allowPrefill">
						<?= Html::textinput($model['app']->id,Html::encode($model["app"]->score),['class' => 'scoreInput', 'id' => 'score_'.$model['app']->score,'name' => $model["app"]->score]); ?>
					</div>
				</div>
				
				<div class="col-sm-12 attachments">
		
					<h2>Anlagen</h2>
					<?= GridView::widget([
						'dataProvider' => $appDataProvider,
						'tableOptions' => ['class' => 'hireMeTable footable toggle-arrow', 'id' => 'uploadedRecruiterView'],
						'id' => "uploadedGrid",
						'columns'      => [
								[
								'label'  => 'Titel',
								'format' => 'raw',
								'value'  => function ($data) {
									return  ApplicationController::getFileTitle($data->file_id);
								},				
								'headerOptions'  => ['class' => 'first-col'],
								'contentOptions' => ['class' => 'first-col'],
								], 
								[
								'label'  => '',
								'format' => 'raw',
								'value'  => function ($data) {
									return Html::a("<span class='glyphicon glyphicon-eye-open'></span>&nbsp;Ansehen","/application/show-file?id=".$data->file_id,['target' => '_blank']);
								},
								'headerOptions'  => ['class' => 'second-col','data-hide' => 'mediaXsmall, phone'],
									'contentOptions' => ['class' => 'second-col'],
								],
								[
								'class'          => 'yii\grid\Column',
								'headerOptions'  => ['data-toggle' => 'true'],
								'contentOptions' => ['data-title' => 'data-toggle'],
								],
							],
						]);
					
					?>
				
				</div>
				
			</div>
		
		</div>
		
		<? /* Show Current Job and School if Available */ ?>
		<? /* Implement when available */ ?>
		<!-- <div class="row">
		
			<? /*if($currentJobsDataProvider->getCount() > 0  || $currentSchoolsDataProvider->getCount() > 0 ):*/ ?>
				<div class="col-sm-4 currentJob">
					<?
					/*

					echo $this->render('/resume/_resume', [
						'jobDataProvider'            => $jobDataProvider,
						'schoolDataProvider'         => $schoolDataProvider,
						'currentJobsDataProvider'    => $currentJobsDataProvider,
						'currentSchoolsDataProvider' => $currentSchoolsDataProvider,
						'edit'                       => false,
						'label'                      => 'Bearbeiten',
						'url1'                       => ['/resume'],
						'url2'                       => ['/resume'],
						'order'                      => 'currentJob',
						'showButtons'                => $user->getId() == Yii::$app->user->identity->getId()
					]);
					?>
				</div>
				<div class="col-sm-4 currentSchool">
					<?
					echo $this->render('/resume/_resume', [
						'jobDataProvider'            => $jobDataProvider,
						'schoolDataProvider'         => $schoolDataProvider,
						'currentJobsDataProvider'    => $currentJobsDataProvider,
						'currentSchoolsDataProvider' => $currentSchoolsDataProvider,
						'edit'                       => false,
						'label'                      => 'Bearbeiten',
						'url1'                       => ['/resume'],
						'url2'                       => ['/resume'],
						'order'                      => 'currentSchool',
						'showButtons'                => $user->getId() == Yii::$app->user->identity->getId()
					]);*/
					?>
				</div>
			
			<? /* endif; */ ?>
		</div>-->
		<? /* Endif is for Recent School/Job */ ?>
		
		
		
		<div class="col-sm-7">
			<p>Datum: <?= $model["created"];?></p>
			<h2>Anschreiben</h2>
			<?= Html::decode("<pre>".$model['coverText']."</pre>"); ?>
		</div>
		
		<div class="col-sm-7">
		
			<div class="row second">
				<div class="col-sm-12">
					<h2>Lebenslauf</h2>
				</div>
			
				<div class="col-sm-6">
				<h3>Beruflich</h3>
					<?= GridView::widget([
						'dataProvider' => $jobProvider,
						'tableOptions' => ['class' => 'hireMeTable footable toggle-arrow', 'id' => 'inboxTable'],
						'id' => "schoolGrid",
						'columns'      => [

							[
								'label'  => 'Unternehmen',
								'format' => 'raw',
								'value'  => function ($data) {
									return  Company::findOne($data->company_id)->name;
								},
								'headerOptions'  => ['class' => 'first-col'],
								'contentOptions' => ['class' => 'first-col'],
							], 
						   [
								'label'  => 'Von',
								'format' => 'raw',
								'value'  => function ($data) {
									return  $data->begin;
								},
								'headerOptions'  => ['class' => 'second-col','data-hide' => 'mediaXsmall, phone'],
								'contentOptions' => ['class' => 'second-col'],
							], 
							  [
								'label'  => 'Bis',
								'format' => 'raw',
								'value'  => function ($data) {
									return  $data->end;
								},
								'headerOptions'  => ['class' => 'third-col','data-hide' => 'mediaXsmall, phone'],
								'contentOptions' => ['class' => 'third-col'],
							], 
							 [
								'label'  => 'Position',
								'format' => 'raw',
								'value'  => function ($data) {
									return  $data->type;
								},
								'headerOptions'  => ['class' => 'fourth-col'],
								'contentOptions' => ['class' => 'fourth-col'],
							], 
							[
								'label'  => 'Nachweis',
								'format' => 'raw',
								'visible' => isset($data->report_id),
								'value'  => function ($data) {
									return Html::a("<span class='glyphicon glyphicon-eye-open'></span>&nbsp;Ansehen","/application/show-file?id=".$data->report_id,['target' => '_blank']);
								},
								'headerOptions'  => ['class' => 'fifth-col','data-hide' => 'mediaXsmall, phone'],
								'contentOptions' => ['class' => 'fifth-col'],
							],
							[
							'class'          => 'yii\grid\Column',
							'headerOptions'  => ['data-toggle' => 'true'],
							'contentOptions' => ['data-title' => 'data-toggle'],
							],
							
						],
					]);  
					?>
				</div>
				
				
				
				<div class="col-sm-6">
				<h3>Schulisch</h3>					
					<?= GridView::widget([
						'dataProvider' => $schoolProvider,
						'tableOptions' => ['class' => 'hireMeTable footable toggle-arrow', 'id' => 'applicationSchoolTable'],
						'id' => "schoolGrid",
						'columns'      => [

							[
								'label'  => 'Ausbildungsstätte',
								'format' => 'raw',
								'value'  => function ($data) {
									return  $data->schoolname;
								},
								'headerOptions'  => ['class' => 'first-col'],
								'contentOptions' => ['class' => 'first-col'],
							], 
						   [
								'label'  => 'Von',
								'format' => 'raw',
								'value'  => function ($data) {
									return  $data->begin;
								},
								'headerOptions'  => ['class' => 'second-col','data-hide' => 'mediaXsmall, phone'],
								'contentOptions' => ['class' => 'second-col'],
							], 
							  [
								'label'  => 'Bis',
								'format' => 'raw',
								'value'  => function ($data) {
									return  $data->end;
								},
								'headerOptions'  => ['class' => 'third-col','data-hide' => 'mediaXsmall, phone'],
								'contentOptions' => ['class' => 'third-col'],
							], 
							[
								'label'  => 'Abschluss',
								'format' => 'raw',
								'value'  => function ($data) {
									return  $data->graduation;
								},
								'headerOptions'  => ['class' => 'fourth-col'],
								'contentOptions' => ['class' => 'fourth-col'],
							], 
							[
								'label'  => 'Nachweis',
								'format' => 'raw',
								'visible' => isset($data->report_id),
								'value'  => function ($data) {
									return Html::a("<span class='glyphicon glyphicon-eye-open'></span>&nbsp;Ansehen","/application/show-file?id=".$data->report_id,['target' => '_blank']);
								},
								'headerOptions'  => ['class' => 'fifth-col','data-hide' => 'mediaXsmall, phone'],
								'contentOptions' => ['class' => 'fifth-col'],
							],
							[
							'class'          => 'yii\grid\Column',
							'headerOptions'  => ['data-toggle' => 'true'],
							'contentOptions' => ['data-title' => 'data-toggle'],
							],
						],
					]);  
					?>
							
				</div>
			
			</div>
		
		</div>
		
	</div>
	
</div>
	
	
	
   
    
	
	<? /* View as Recruiter End */ ?>
	
    <? else: ?>
	
	<? /* View as User */ ?>
	
    <h1><?= Html::encode($this->title) ?></h1>
    <h2>Anschreiben:</h2>
    <p>
    <?= $model['coverText']; ?>
    </p>
    <br>   
    <h2>Gesendete Anlagen</h2>
    

    <?= GridView::widget([
        'dataProvider' => $appDataProvider,
        'tableOptions' => ['class' => 'hireMeTable footable toggle-arrow', 'id' => 'inboxTable'],
        'id' => "uploadedGrid",
        'columns'      => [

            [
                'label'  => 'Titel',
                'format' => 'raw',
                'value'  => function ($data) {
                    return  ApplicationController::getFileTitle($data->file_id);
                },				
				'headerOptions'  => ['class' => 'first-col'],
				'contentOptions' => ['class' => 'first-col'],
            ], 
            [

                'label'  => '',
                'format' => 'raw',
                'value'  => function ($data) {
                    return Html::a("<span class='glyphicon glyphicon-eye-open'></span>&nbsp;Ansehen","/application/show-file?id=".$data->file_id,['target' => '_blank']);
                },
				'headerOptions'  => ['class' => 'second-col','data-hide' => 'mediaXsmall, phone'],
				'contentOptions' => ['class' => 'second-col'],
            ],
			[
				'class'          => 'yii\grid\Column',
				'headerOptions'  => ['data-toggle' => 'true'],
				'contentOptions' => ['data-title' => 'data-toggle'],
			],
        ],
    ]);
	
	?>
	
	<? endif; ?>
	
	<? /* View as User End */ ?>
	
	<? /* View as Recruiter */ ?>
	
    <? if (Yii::$app->user->identity->isRecruiter()): ?>
    
    <?= Html::a(Html::button("Nachricht senden"),"/message/create?rec=".$model["user"]->id); ?>
    <?= Html::a(Html::button("Zum Gespräch einladen"),"/application/app-action?app=".$model["app"]->id."&act=0"); ?>
    <?= Html::a(Html::button("Stelle besetzen"),"/application/app-action?app=".$model["app"]->id."&act=1"); ?>
    <?= Html::a(Html::button("Archivieren"),"/application/app-action?app=".$model["app"]->id."&act=2"); ?>

    <? endif; ?>

	<? /* View as Recruiter Emd */ ?>
	
</div>
