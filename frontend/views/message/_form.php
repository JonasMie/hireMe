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

    <?= $form->field($model, 'subject')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>

    <?
    $template =
        '<p>{{value}}</p>' .
        '<img src="/uploads/profile/{{image}}.jpg"/>';

    echo $form->field($model, 'receiver')->widget(Typeahead::className(), [
        'name'         => 'receiver_name',
        'dataset'      => [
            [
                'remote'    => Url::to(['site/user-search' . '?q=%QUERY']),
                'limit'     => 10,
                'templates' => [
                    'empty'      => '<div class="text-error">Es wurde leider kein Nutzer gefunden.</div>',
                    'suggestion' => new JsExpression("Handlebars.compile('{$template}')")
                ]
            ],
        ],
    ])->label('Empfänger') ?>

    <?= $form->field($model, 'attachment')->fileInput()->label('Anhang hinzufügen'); ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Create'), ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>