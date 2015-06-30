<?php
/**
 * Created by Jonas Miederer.
 * User: jonas
 * Date: 09.06.15
 * Time: 22:22
 * Project: hireMe
 */
use kartik\date\DatePicker;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

?>

<div class="resume-school-form">



    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'schoolname')->textInput(['maxlength' => 255])->label('Name der Schule') ?>

    <?= $form->field($model, 'graduation')->textInput(['maxlength' => 255])->label('Abschluss') ?>

    <?= $form->field($model, 'current')->checkbox()->label('Aktuelle Ausbildung') ?>

    <?
    echo DatePicker::widget([
        'model' => $model,
        'attribute' => 'begin',
        'attribute2' => 'end',
        'options' => ['placeholder' => 'Von'],
        'options2' => ['placeholder' => 'Bis'],
        'type' => DatePicker::TYPE_RANGE,
        'form' => $form,
        'language' => 'de',
        'pluginOptions' => [
            'format' => 'dd.mm.yyyy',
            'autoclose' => true,
            'todayHighlight' => true,
        ]
    ]);
    ?>




    <?= $form->field($model, 'report_id')->fileInput()->label('Anhang hinzufügen') ?>



    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', '<span class="glyphicon glyphicon-floppy-disk"></span>&nbsp;&nbsp;Speichern') : Yii::t('app', '<span class="glyphicon glyphicon-floppy-saved"></span>&nbsp;&nbsp;Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>


</div>
