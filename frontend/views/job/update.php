<?php

use yii\helpers\Html;

/* @var $this yii\web\View */

/* @var $model frontend\models\Job */

$this->title = 'Update Job: ' . ' ' . $model->title;

/* @var $model frontend\models\Job */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Job',
]) . ' ' . $model->title;

?>
<div class="job-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('updateForm', [
        'model' => $model,
    ]) ?>

</div>
