<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use frontend\assets\CreateJobAsset;
use yii\widgets\Pjax;
use yii\helpers\Url;
use kartik\date\DatePicker;
use kartik\typeahead\Typeahead;

include Yii::getAlias('@helper/companySignup.php');

/* @var $this yii\web\View */
/* @var $model frontend\models\Job */
/* @var $form yii\widgets\ActiveForm */
CreateJobAsset::register($this);

$this->title = 'Stellenanzeige erstellen';
/* @var $model frontend\models\Job */

?>
<div class="job-create">
    <div class="row">

        <h1><?= Html::encode($this->title) ?></h1>

        <?php $form = ActiveForm::begin(['id' => 'form-createJob']); ?>

        <div class="col-sm-6">


            <?= $form->field($model, 'title')->label('Titel') ?>

            <?= $form->field($model, 'description', ['inputOptions' => ['class' => 'form-control', 'placeholder' => 'Beschreibung...']], ['options' => ['class' => 'form-control']])->textarea(['rows' => 15])->label(false) ?>

        </div>

        <div class="col-sm-6 col-2nd">

            <?
            echo DatePicker::widget([
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

            <?= $form->field($model, 'sector')->widget(\kartik\select2\Select2::className(), [
                'data' => $sectors,
                'options' => ['prompt' => ''],
            ])->label('Branche auswählen') ?>

            <?= $form->field($model, 'checkLocationBased')->checkbox(array('id' => 'checkLocationBased'))->label('Ortsbasiert') ?>

            <div class="locationDiv" style="display: none">    <? //STYLE: display in css?>
                <?= $form->field($model, 'zip')->label('Postleitzahl') ?>
                <?= $form->field($model, 'city')->label('Stadt') ?>
            </div>

            <div class="form-group field-submit">
                <?= Html::submitButton('Erstellen', ['class' => 'btn btn-success', 'name' => 'create-button']) ?>
            </div>
            <?php ActiveForm::end(); ?>

            <!-- <div id="aboutdiv">
                <?php Pjax::begin() ?>
                    <?= Html::a(
                        'Button generieren',
                        Url::to(['job/generation?id=' . $assumedJobId]),
                        ['data-pjax' => '#aboutdiv']
                    ) ?>
                <?php Pjax::end(); ?>
             </div> -->
        </div>
    </div>
</div>