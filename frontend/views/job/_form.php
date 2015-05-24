<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Job */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="job-form">

    <?php $form = ActiveForm::begin(); ?>

<<<<<<< HEAD
=======
    <?= $form->field($model, 'id')->textInput() ?>

>>>>>>> bc255c11865ac6559952248f9b47f4fe9381674c
    <?= $form->field($model, 'description')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'job_begin')->textInput() ?>

    <?= $form->field($model, 'job_end')->textInput() ?>

    <?= $form->field($model, 'zip')->textInput(['maxlength' => 10]) ?>

    <?= $form->field($model, 'sector')->textInput() ?>

    <?= $form->field($model, 'company_id')->textInput() ?>

    <?= $form->field($model, 'active')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

<<<<<<< HEAD
    <?= $form->field($model, 'title')->textInput(['maxlength' => 100]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
=======
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
>>>>>>> bc255c11865ac6559952248f9b47f4fe9381674c
    </div>

    <?php ActiveForm::end(); ?>

</div>
