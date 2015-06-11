<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\ApplyBtn */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="apply-btn-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'site')->textarea(['rows' => 1]) ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
