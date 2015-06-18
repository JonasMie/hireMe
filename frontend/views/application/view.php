<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use frontend\models\Application;
use yii\grid\GridView;
use frontend\controllers\ApplicationController;
/* @var $this yii\web\View */
/* @var $model frontend\models\Application */

?>
<div class="application-view">


    <? if (Yii::$app->user->identity->isRecruiter()): ?>
    <?
        $model["app"]->read = 1;
        $model["app"]->save();
    ?>
    <h2><?= $model["user"]->getProfilePicture(true) ?><?= $model["user"]->fullName ?>'s Bewerbung:</h2>
    <p> Eingestellt: <?= $model["created"];?></p>
    <p><?= Html::a(Html::button("Lebenslauf anschauen"),"") ?></p>
   
    <? else: ?>
     <h2>Meine Bewerbung auf: <?= $model['job']->title ?></h2>
    <h3> Gesendete Anlagen:</h3>
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
                }
            ], 
            [

                'label'  => 'Info',
                'format' => 'raw',
                'value'  => function ($data) {
                    return Html::a("Anschauen","/application/show-file?id=".$data->id,['target' => '_blank']);
                }
            ],
        ],
    ]); ?>  
    <? if (Yii::$app->user->identity->isRecruiter()): ?>
    
    <?= Html::a(Html::button("Nachricht senden"),"/message/create?rec=".$model["user"]->id); ?>
    <?= Html::a(Html::button("Einstellen"),"/application/app-action?app=".$model["app"]->id."&act=1"); ?>
    <?= Html::a(Html::button("Archivieren"),"/application/app-action?app=".$model["app"]->id."&act=0"); ?>

    <? endif; ?>

</div>
