<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use frontend\models\Application;
use yii\grid\GridView;
use frontend\controllers\ApplicationController;
use frontend\models\ResumeJob;
use frontend\models\ResumeSchool;
use frontend\models\Company;

/* @var $this yii\web\View */
/* @var $model frontend\models\Application */

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


    <? if (Yii::$app->user->identity->isRecruiter()): ?>
    <?
        $model["app"]->read = 1;
        $model["app"]->save();
    ?>
    <h2><?= $model["job"]->title ?> </h2>
    <h2><?= $model["user"]->getProfilePicture(true) ?><?= $model["user"]->fullName ?>'s Bewerbung:</h2>
    <p> Beworben am: <?= $model["created"];?></p>
    <br>
     <h2>Anschreiben:</h2>
    <p>
    <?= $model['coverText']; ?>
    </p>
    <h2>Lebenslauf:</h2>
    <p>
        <h4>Schulische Ausbildung:</h4>

        <?= GridView::widget([
        'dataProvider' => $schoolProvider,
        'tableOptions' => ['class' => 'hireMeTable footable toggle-arrow', 'id' => 'inboxTable'],
        'id' => "schoolGrid",
        'columns'      => [

            [
                'label'  => 'Schule',
                'format' => 'raw',
                'value'  => function ($data) {
                    return  $data->schoolname;
                }
            ], 
           [
                'label'  => 'Von',
                'format' => 'raw',
                'value'  => function ($data) {
                    return  $data->begin;
                }
            ], 
              [
                'label'  => 'Bis',
                'format' => 'raw',
                'value'  => function ($data) {
                    return  $data->end;
                }
            ], 
            [
                'label'  => 'Abschluss',
                'format' => 'raw',
                'value'  => function ($data) {
                    return  $data->graduation;
                }
            ], 
            [
                'label'  => 'Nachweis',
                'format' => 'raw',
                'value'  => function ($data) {
                    return Html::a("Ansehen","/application/show-file?id=".$data->report_id,['target' => '_blank']);
                }
            ], 
        ],
    ]);  
    ?>

     <h4>Arbeitserfahrung:</h4>

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
                }
            ], 
           [
                'label'  => 'Von',
                'format' => 'raw',
                'value'  => function ($data) {
                    return  $data->begin;
                }
            ], 
              [
                'label'  => 'Bis',
                'format' => 'raw',
                'value'  => function ($data) {
                    return  $data->end;
                }
            ], 
             [
                'label'  => 'Position',
                'format' => 'raw',
                'value'  => function ($data) {
                    return  $data->type;
                }
            ], 
            [
                'label'  => 'Nachweis',
                'format' => 'raw',
                'value'  => function ($data) {
                    return Html::a("Ansehen","/application/show-file?id=".$data->report_id,['target' => '_blank']);
                }
            ],
			
        ],
    ]);  
    ?>
    </p>
    <br>
    <br>   
    <h2>
    Gesendete Anlagen
</h2>
    <? else: ?>
     <h1>Meine Bewerbung auf: <?= Html::a($model['job']->title,"/job/view?id=".$model['job']->id) ?></h1>
    <h2>Anschreiben:</h2>
    <p>
    <?= $model['coverText']; ?>
    </p>
    <br>   
    <h2> Gesendete Anlagen:</h2>
    <? endif; ?>

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
				'headerOptions'  => ['class' => 'second-col','data-hide' => 'xsmall, phone'],
				'contentOptions' => ['class' => 'second-col'],
            ],
			[
				'class'          => 'yii\grid\Column',
				'headerOptions'  => ['data-toggle' => 'true'],
				'contentOptions' => ['data-title' => 'data-toggle'],
			],
        ],
    ]); ?>  
    <? if (Yii::$app->user->identity->isRecruiter()): ?>
    
    <?= Html::a(Html::button("Nachricht senden"),"/message/create?rec=".$model["user"]->id); ?>
    <?= Html::a(Html::button("Zum Gespräch einladen"),"/application/app-action?app=".$model["app"]->id."&act=0"); ?>
    <?= Html::a(Html::button("Stelle besetzen"),"/application/app-action?app=".$model["app"]->id."&act=1"); ?>
    <?= Html::a(Html::button("Archivieren"),"/application/app-action?app=".$model["app"]->id."&act=2"); ?>

    <? endif; ?>

</div>
