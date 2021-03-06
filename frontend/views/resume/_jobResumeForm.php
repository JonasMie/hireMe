<?php

use kartik\date\DatePicker;
use kartik\typeahead\Typeahead;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\ResumeJob */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="resume-job-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'type')->textInput(['maxlength' => 255])->label('Berufsbezeichnung') ?>

    <?= $form->field($model, 'company_id')->textInput()->widget(Typeahead::classname(), [
        'pluginOptions' => ['highlight' => true],
        'dataset'       => [
            [
                'remote' => Url::to(['site/company-search' . '?q=%QUERY']),
                'limit'  => 10,
            ],

        ]
    ])->label('Unternehmen') ?>

    <?= $form->field($model, 'description', ['inputOptions' => ['class' => 'form-control', 'placeholder' => 'Beschreibung der Tätigkeit...']], ['options' => ['class' => 'form-control']])->textarea(['rows' => 7]) ->label(false) ?>

    <?= $form->field($model, 'current')->checkbox() ?>

    <?
    echo DatePicker::widget([
        'model'         => $model,
        'attribute'     => 'begin',
        'attribute2'    => 'end',
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


    <?= $form->field($model, 'report_id')->fileInput()->label('Anhang hinzufügen')?>

    <div class="form-group form-group-submit">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', '<span class="glyphicon glyphicon-floppy-disk"></span>&nbsp;&nbsp;Speichern') : Yii::t('app', '<span class="glyphicon glyphicon-floppy-saved"></span>&nbsp;&nbsp;Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
