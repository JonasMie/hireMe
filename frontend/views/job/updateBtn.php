<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\ApplyBtn */

$this->title = 'Update Apply Btn: ' . ' ' . $model->id;
?>
<div class="apply-btn-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_formBtn', [
        'model' => $model,
    ]) ?>

</div>
