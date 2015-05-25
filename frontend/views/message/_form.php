<?php

use kartik\typeahead\Typeahead;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Message */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="message-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'subject')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>

    <?=
    // TODO: set receiver if $rec!== null
    Typeahead::widget([
        'name' => 'receiver_name',
        'dataset' => [
            [
                'remote' => Url::to(['site/user-search'.'?q=%QUERY']),
                'limit' => 10,
            ],
        ],
        'pluginEvents' => [     // Typeahead search with bloodhound suggestion
            "typeahead:selected" => 'function(x,y) {$("#message-receiver_id").val(y.id)}',
        ]

    ])?>

    <!--?= $form->field($model, 'receiver_id')->widget(Typeahead::className(), [
        'dataset' => [
            [
                'remote' => Url::to(['site/user-search'.'?q=%QUERY']),
                'limit' => 10,
            ],
        ],
        'pluginEvents' => [
            "typeahead:selected" => 'function(x,y) {$("#message-receiver_id").val(y.id)}',
        ]

    ])->label('Empfänger')->textInput()  ?-->

    <?= Html::activeHiddenInput($model, 'receiver_id') // TODO: check if exists ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Create'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>
