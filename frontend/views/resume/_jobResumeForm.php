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

    <?= $form->field($model, 'description', ['inputOptions' => ['class' => 'form-control', 'placeholder' => 'Beschreibung der Tätigkeit...']], ['options' => ['class' => 'form-control']])->textarea(['rows' => 5]) ->label(false) ?>

    <?= $form->field($model, 'current')->checkbox() ?>

    <?
    echo DatePicker::widget([
        'model'         => $model,
        'attribute'     => 'begin',
        'attribute2'    => 'end',
        'options'       => ['placeholder' => 'Beginn'],
        'options2'      => ['placeholder' => 'Ende'],
        'type'          => DatePicker::TYPE_RANGE,
        'form'          => $form,
        'language'      => 'de',
        'pluginOptions' => [
            'format'         => 'dd.mm.yyyy',
            'autoclose'      => true,
            'todayHighlight' => true,
        ]
    ]);
    ?>


    <?= $form->field($model, 'report_id')->fileInput()->label('Anhang hinzufügen')?>

    <div class="form-group form-group-submit">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Speichern') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
