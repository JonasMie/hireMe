<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\ApplyBtn */

$this->title = 'Create Apply Btn';
?>
<div class="apply-btn-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_formBtn', [
        'model' => $model,
    ]) ?>

</div>
