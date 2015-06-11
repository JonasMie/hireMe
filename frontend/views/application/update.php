<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Application */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Application',
]) . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Applications'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="application-update">

    <h1><?= Html::encode($this->title) ?></h1>


</div>
