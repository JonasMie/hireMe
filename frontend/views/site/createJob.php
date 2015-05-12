<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\CreateJobForm */
/* @var $form ActiveForm */

?>
<div class="createJob">

   	<?php $form = ActiveForm::begin(); ?>
   	
        <?= $form->field($model, 'title') ?>
        <?= $form->field($model, 'description') ?>
        <?= $form->field($model, 'job_begin') ?>
        <?= $form->field($model, 'zip') ?>
        <?= $form->field($model, 'sector') ?>
    
        <div class="form-group">
            <?= Html::submitButton('Erstellen', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- createJob -->
