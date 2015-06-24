<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Cover */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Cover',
]) . ' ' . $model->title;
?>
<div class="cover-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
