<?php

use kartik\typeahead\Typeahead;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\Message */
/* @var $form yii\widgets\ActiveForm */
/* @var $attachment frontend\models\MessageAttachments */
/* @var $receiver null|common\models\User */
?>


<div class="message-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <div class="message-create-first-row">


        <?
        $template =
            '<img src="/uploads/profile/{{image}}.jpg"/>' .
            '<p>{{value}}</p>';

        echo $form->field($model, 'receiver')->widget(Typeahead::className(), [
            'name' => 'receiver_name',
            'dataset' => [
                [
                    'remote' => Url::to(['site/user-search' . '?q=%QUERY']),
                    'limit' => 10,
                    'templates' => [
                        'empty' => '<div class="text-error">Es wurde leider kein Nutzer gefunden.</div>',
                        'suggestion' => new JsExpression("Handlebars.compile('{$template}')")
                    ]
                ],
            ],
        ])->label('Empfänger') ?>
    </div>

    <div class="message-create-second-row">

        <?= $form->field($model, 'subject')->textInput(['maxlength' => 255]) ?>

    </div>


    <?= $form->field($model, 'content', ['inputOptions' => ['class' => 'form-control', 'placeholder' => 'Nachricht...']], ['options' => ['class' => 'form-control']])->textarea(['rows' => 15]) ->label(false) ?>



    <?= $form->field($model, 'attachment')->fileInput()->label('Anhang hinzufügen'); ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', '<span class="glyphicon glyphicon-share"></span>&nbsp;&nbsp;Nachricht versenden'), ['class' => 'btn btn-success']) ?>

    </div>
    <?php ActiveForm::end(); ?>

</div>