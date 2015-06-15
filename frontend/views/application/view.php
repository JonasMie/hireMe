<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use frontend\models\Application;

/* @var $this yii\web\View */
/* @var $model frontend\models\Application */

$this->title = $model->id;
?>
<div class="application-view">


    <?php
        if(Yii::$app->user->identity->isRecruiter()) {
        $model->read = 1;
        $model->save();}
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

    <? endif; ?>


    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'user_id',
            'company_id',
            'job_id',
            'score',
            'state',
            'sent',
            'read',
            'archived',
            'created_at',
        ],
    ]) ?>

</div>
