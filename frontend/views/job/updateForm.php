<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\Job */
/* @var $form yii\widgets\ActiveForm */


?>

<div class="job-form">

     <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
                <?= $form->field($model, 'title')->label('Titel')?>
                <?= $form->field($model, 'description')->textarea() ?>
                <?= $form->field($model, 'job_begin')->label() ?>
                <?= $form->field($model, 'job_end')->label() ?>
                <?= $form->field($model, 'sector')->label("Sektor wählen") ?>
                <?= $form->field($model, 'type')->label("Type") ?>
                <?= $form->field($model, 'time')->label("time") ?>
                <?= $form->field($model, 'zip')->label('Postleitzahl') ?>
                <?= $form->field($model, 'city')->label('Stadt') ?>
                <div class="form-group">
                    <?= Html::submitButton('Speichern', ['class' => 'btn btn-primary', 'name' => 'create-button']) ?>
                </div>
            <?php ActiveForm::end(); ?>

</div>
