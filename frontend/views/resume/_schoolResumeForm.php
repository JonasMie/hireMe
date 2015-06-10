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
    <?
    echo '<label class="control-label">Schulzeit</label>';
    echo DatePicker::widget([
        'model' => $model,
        'attribute' => 'begin',
        'attribute2' => 'end',
        'options' => ['placeholder' => 'Beginn'],
        'options2' => ['placeholder' => 'Ende'],
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

    <? //= $form->field($model, 'current')->textInput() ?>

    <?= $form->field($model, 'schoolname')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'graduation')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'report_id')->fileInput() ?>



    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
