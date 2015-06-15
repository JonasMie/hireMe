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


    <?php
        if(Yii::$app->user->identity->isRecruiter()) {
        $model["app"]->read = 1;
        $model["app"]->save();}
    ?>

    <? if (Yii::$app->user->identity->isRecruiter() == false): ?>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <? else: ?>

    <h2><?= $model["user"]->fullName ?>'s Bewerbung:</h2>
    <p>Eingestellt: <?= $model["created"];?></p>
    <h3>Gesendete Anlagen:</h3>

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
                    return Html::a("Anschauen","/application/show-file?id=".$data->id);
                }
            ],
        ],
    ]); ?>  


    <? endif; ?>
   

    <? if (Yii::$app->user->identity->isRecruiter()): ?>



    <? endif; ?>

</div>
