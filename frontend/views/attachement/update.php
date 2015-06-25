<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\File */

?>
<div class="file-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'title' => $model->title,
    ]) ?>

</div>
