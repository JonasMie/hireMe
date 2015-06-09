<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\Application */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="application-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

    <h3>Deine Qualifikationen:</h3>

    <?= $form->field($model, 'file')->fileInput(['multiple' => false]) ?>
    <?= $form->field($model, 'title')->input("Titel:") ?>

    <div class="form-group">
        <?= Html::submitButton("Erstellen") ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
