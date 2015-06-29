<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use frontend\assets\CreateJobAsset;
use kartik\date\DatePicker;
use kartik\typeahead\Typeahead;
CreateJobAsset::register($this);

include Yii::getAlias('@helper/companySignup.php');
/* @var $this yii\web\View */
/* @var $model frontend\models\Job */
/* @var $form yii\widgets\ActiveForm */


?>

<div class="job-form">

    <div class="col-sm-6">
            <?php $form = ActiveForm::begin(['id' => 'form-createJob']); ?>
                <?= $form->field($model, 'title')->label('Titel')?>    
                <?= $form->field($model, 'description')->textarea() ?>
                <?=
                DatePicker::widget([
                    'model'         => $model,
                    'attribute'     => 'job_begin',
                    'attribute2'    => 'job_end',
                    'options'       => ['placeholder' => 'Von'],
                    'options2'      => ['placeholder' => 'Bis'],
                    'type'          => DatePicker::TYPE_RANGE,
                    'form'          => $form,
                    'language'      => 'de',
                    'separator'     => 'bis',
                    'pluginOptions' => [
                        'format'         => 'dd.mm.yyyy',
                        'autoclose'      => true,
                        'todayHighlight' => true,
                    ]
                ]);
                ?>
                <?= $form->field($model, 'zip')->label('Postleitzahl') ?>
                <?= $form->field($model, 'city')->label('Stadt') ?>
                 <?= $form->field($model, 'sector')->widget(\kartik\select2\Select2::className(), [
                    'data' => $sectors,
                ])->label('Branche auswählen') ?>
              
                <div class="form-group">
                    <br>
                    <br>
                    <br>
                    <?= Html::submitButton('Speichern', ['class' => 'btn btn-success', 'name' => 'create-button']) ?>
                </div>
            <?php ActiveForm::end(); ?>


</div>

</div>
