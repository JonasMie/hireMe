<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\ApplyBtn */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="apply-btn-form">

    <?php $form = ActiveForm::begin(); ?>

	<?= $form->field($model, 'site',['options' => ['class' => 'allowPrefill']])->label('Beschreibung'); ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Erstellen' : 'Aktualisieren', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
