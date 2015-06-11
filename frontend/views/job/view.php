<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use frontend\models\Company;
use frontend\models\Job;
use frontend\models\Application;
use frontend\controllers\JobController;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Job */

?>
<div class="job-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <? if (Yii::$app->user->identity->isRecruiter()): ?>

        <?= Html::a(Yii::t('app', 'Update'), ['update-job', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete-job', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>

        <? endif; ?>

    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'description',
            'job_begin',
            'job_end',
            'zip',
            'sector',
            [                      // the owner name of the model
            'label' => 'Company',
            'value' => Company::getNameById($model->company_id),
            ],
            'active',
            'created_at',
            'type',
            'city',
            'time:datetime',
        ],
    ]) ?>

    <? if (Yii::$app->user->identity->isRecruiter()): ?>
     <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'key:ntext',
            'site:ntext',
            [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{update}{delete}',
            ],
        ],
         'caption'  => Html::a("Neuen Key generieren",'/job/create-btn?id='.$model->id),
    ]); ?>
    <? else: ?>
     <? if (Application::existsApplicationFromUser(Yii::$app->user->identity->id,$model->id) == true) :?>
        <?= Html::decode("Bewerbung ist bereits raus.<br>Status: ".Application::getApplicationStatByUserAndJob(Yii::$app->user->identity->id,$model->id)) ?>
        <?= Html::a(Html::button("Jetzt bewerben"),"/job/apply-intern?id=".$model->id); ?>   
    <? endif; ?>
    <? endif; ?>

</div>
