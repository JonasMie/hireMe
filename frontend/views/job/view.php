<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use frontend\models\Company;
use frontend\models\Job;
use frontend\models\Application;
use frontend\controllers\JobController;

/* @var $this yii\web\View */
/* @var $model frontend\models\Job */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Jobs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="job-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>

        <? if (Yii::$app->user->identity->isRecruiter()): ?>

        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
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

    <? if (Yii::$app->user->identity->isRecruiter() == false): ?>
        <? if (Application::existsApplicationFromUser(Yii::$app->user->identity->id,$model->id) == true) :?>
        <?= Html::decode("Bewerbung ist bereits raus.<br>Status: ".Application::getApplicationStatByUserAndJob(Yii::$app->user->identity->id,$model->id)) ?>
        <? else: ?>
        <?= Html::a(Html::button("Jetzt bewerben"),"/job/apply-intern?id=".$model->id); ?>
        <? endif; ?>
    <? endif; ?>


</div>
