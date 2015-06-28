<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use frontend\assets\CreateJobAsset;
use yii\widgets\Pjax;
use yii\helpers\Url;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model frontend\models\Job */
/* @var $form yii\widgets\ActiveForm */
CreateJobAsset::register($this);

$this->title = 'Create Job';
/* @var $model frontend\models\Job */

?>
<div class="job-create">

    <h1><?= Html::encode($this->title) ?></h1>
			
			<?php $form = ActiveForm::begin(['id' => 'form-createJob']); ?>
                <?= $form->field($model, 'title')->label('Titel')?>
                
                <?= $form->field($model, 'description')->textarea() ?>
                <?
                echo DatePicker::widget([
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
                <?= $form->field($model, 'sector')->label("Sektor wählen") ?>
                <?= $form->field($model, 'type')->label("Type") ?>
                <?= $form->field($model, 'time')->label("time") ?>
                
                <?= $form->field($model, 'checkLocationBased')->checkbox(array('id'=>'checkLocationBased'))->label('Ortsbasiert') ?>

                <div class="locationDiv" style="display: none">    <? //STYLE: display in css?>
                <?= $form->field($model, 'zip')->label('Postleitzahl') ?>
                <?= $form->field($model, 'city')->label('Stadt') ?>
                </div>

                <div class="form-group">
                    <?= Html::submitButton('Erstellen', ['class' => 'btn btn-primary', 'name' => 'create-button']) ?>
                </div>
            <?php ActiveForm::end(); ?>

 <div id="aboutdiv">

 <?php Pjax::begin() ?>

        <?= Html::a(
            'Button generieren',
            Url::to(['job/generation?id='.$assumedJobId]),
            ['data-pjax'=> '#aboutdiv']
        ) ?>

    <?php Pjax::end(); ?>

 </div>

</div>
