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
    <div class="row">

        <?php $form = ActiveForm::begin(['id' => 'form-createJob']); ?>

        <div class="col-sm-6">


            <?= $form->field($model, 'title', ['options' => ['class' => 'allowPrefill form-group has-success']])->label('Titel') ?>

            <?= $form->field($model, 'description', ['inputOptions' => ['class' => 'form-control', 'placeholder' => 'Beschreibung...']], ['options' => ['class' => 'form-control']])->textarea(['rows' => 15])->label(false) ?>

        </div>

        <div class="col-sm-6 col-2nd">


            <?=
            DatePicker::widget([
                'model' => $model,
                'attribute' => 'job_begin',
                'attribute2' => 'job_end',
                'options' => ['placeholder' => 'Von'],
                'options2' => ['placeholder' => 'Bis'],
                'type' => DatePicker::TYPE_RANGE,
                'form' => $form,
                'language' => 'de',
                'separator' => 'bis',
                'pluginOptions' => [
                    'format' => 'dd.mm.yyyy',
                    'autoclose' => true,
                    'todayHighlight' => true,
                ]
            ]);
            ?>

            <?= $form->field($model, 'zip', ['options' => ['class' => 'allowPrefill form-group has-success']])->label('Postleitzahl') ?>

            <?= $form->field($model, 'city', ['options' => ['class' => 'allowPrefill form-group has-success']])->label('Stadt') ?>

            <?= $form->field($model, 'sector', ['options' => ['class' => 'form-group has-success']])->widget(\kartik\select2\Select2::className(), [
                'data' => $sectors,
                'options' => ['prompt' => ''],
            ])->label('Branche') ?>

            <div class="form-group">
                <?= Html::submitButton('Speichern', ['class' => 'btn btn-success', 'name' => 'create-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div>
</div>

