<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;
use frontend\assets\CreateJobAsset;
use kartik\date\DatePicker;
use kartik\typeahead\Typeahead;

CreateJobAsset::register($this);

include Yii::getAlias('@helper/companySignup.php');
/* @var $this yii\web\View */
/* @var $model frontend\models\Job */
/* @var $form yii\widgets\ActiveForm */

$model->job_begin = Yii::$app->formatter->asDate($model->job_begin);
$model->job_end = Yii::$app->formatter->asDate($model->job_end);
?>

<div class="job-form">
    <div class="row">

        <?php $form = ActiveForm::begin(['id' => 'form-createJob']); ?>

        <div class="col-sm-6">


            <?= $form->field($model, 'title', ['options' => ['class' => 'allowPrefill form-group has-success']])->label('Titel') ?>

            <?= $form->field($model, 'description', ['inputOptions' => ['class' => 'form-control', 'placeholder' => 'Beschreibung...']], ['options' => ['class' => 'form-control has-success']])->textarea(['rows' => 15])->label(false) ?>

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
                    'format'         => 'dd.mm.yyyy',
                    'todayHighlight' => true,
                    'convertFormat' =>true,
                ]
            ]);
            ?>

            <? if ($model->zip): ?>
            <?
            $template =
                '<p>{{plz}}  -  {{city}}</p>';

            echo $form->field($model, 'zip')->widget(Typeahead::className(), [
                'name'         => 'zip',
                'dataset'      => [
                    [
                        'remote'    => ['url' => Url::to(['site/geo-search' . '?q=%QUERY'])],
                        'limit'     => 10,
                        'templates' => [
                            'empty'      => '<div class="text-error">Es wurde leider kein Ort gefunden.</div>',
                            'suggestion' => new JsExpression("Handlebars.compile('{$template}')")
                        ],
                        'displayKey' => 'plz',
                    ],
                ],
                'pluginEvents' => [
                    'typeahead:selected' => 'function(e,val) { jQuery("#job-city").val(val.city) }'
                ],
                'container' => ['class' => 'allowPrefill']
            ]) ?>

            <?
            $template =
                '<p>{{plz}}  -  {{city}}</p>';

            echo $form->field($model, 'city')->widget(Typeahead::className(), [
                'name'         => 'companyAddressCity',
                'dataset'      => [
                    [
                        'remote'    => ['url' => Url::to(['site/geo-search' . '?q=%QUERY'])],
                        'limit'     => 10,
                        'templates' => [
                            'empty'      => '<div class="text-error">Es wurde leider kein Ort gefunden.</div>',
                            'suggestion' => new JsExpression("Handlebars.compile('{$template}')")
                        ],
                        'displayKey' => 'city',
                    ],
                ],
                'pluginEvents' => [
                    'typeahead:selected' => 'function(e,val) { jQuery("#job-zip").val(val.plz) }'
                ],
                'container' => ['class' => 'allowPrefill']
            ]) ?>

            <? endif?>

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

