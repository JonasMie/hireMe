<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\JobAd */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Job Ad',
]) . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Job Ads'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="job-ad-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
