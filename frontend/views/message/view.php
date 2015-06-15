<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * @var $this yii\web\View
 * @var $model frontend\models\Message
 * @var $reply frontend\models\Message
 * @var $attachment frontend\models\MessageAttachments
 **/

$this->title = $model->subject;


if ($model->receiver_id === Yii::$app->user->getId()) {
    $model->read = 1;
    $model->save();
}
?>
<div class="message-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>

        <? if (Yii::$app->user->getId() === $model->receiver_id) {
            echo Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data'  => [
                    'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                    'method'  => 'post',
                ],
            ]);
        } ?>

        <?= Html::a(Yii::t('app', 'Reply'), '#', [
            'class' => 'btn btn-info btn-reply',
//            'data'  => [
//                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
//                'method'  => 'post',
//            ],
        ]) ?>


    </p>

    <?
    $attributes = [


        [
            'label'     => Yii::$app->user->getId() === $model->sender_id ? "An" : "Von",
            'format'    => 'raw',
            'attribute' => function ($data) {
                if (Yii::$app->user->getId() === $data->sender_id) {
                    return Html::a($data->receiver->firstName . " " . $data->receiver->lastName, '../user/' . $data->receiver->username);
                } else if (Yii::$app->user->getId() === $data->receiver_id) {
                    return Html::a($data->sender->firstName . " " . $data->sender->lastName, '../user/' . $data->sender->username);
                }
            }
        ],

        'sent_at:datetime:Gesendet',
        'subject:text:Betreff',
        'content:html:Nachricht',

    ];

    if (!empty($model->messageAttachments)) {           // TODO: check multiple attachments
        foreach ($model->messageAttachments as $attachment) {
            switch ($attachment->file->extension) {     // TODO: check file paths
                case "png":
                case "jpg":
                case "gif":
                    array_push($attributes, [
                        'attribute' => 'Anhänge',
                        'value'     => "/uploads/messattachments" . $attachment->file->path . "." . $attachment->file->extension,
                        'format'    => ['image', ['width' => '100', 'height' => '100']],
                    ]);
                    break;
                case "pdf":
                    array_push($attributes, [
                        'label'     => 'Anhänge',
                        'attribute' => function () use ($attachment) {
                            return Html::a($attachment->file->title . "." . $attachment->file->extension, "/uploads/messattachments" . $attachment->file->path . "." . $attachment->file->extension);
                        },
                        'format'    => 'raw'
                    ]);
            }

        }

    }
    echo DetailView::widget([
        'model'      => $model,
        'attributes' => $attributes,
    ]); ?>

</div>

<div class="message-form form-reply" style="display: none">

    <?php
    $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'], 'action' => '/message/create']);
    $reply->subject = "Re: " . $model->subject;
    $reply->receiver_id = $model->receiver_id == Yii::$app->user->getId() ? $model->sender_id : $model->receiver_id;
    $reply->flow = $model->flow;
    ?>

    <?= $form->field($reply, 'subject')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($reply, 'content')->textarea(['rows' => 6]) ?>


    <?= Html::activeHiddenInput($reply, 'receiver_id') // TODO: check if exists       ?>

    <?= $form->field($attachment, 'file')->fileInput()->label('Anhang hinzufügen'); ?>
    <?= Html::activeHiddenInput($reply, 'flow') // TODO: DANKE YII, DASS ICH DEN SCHEIß MIT HIDDEN INPUT MACHEN MUSS! DANKE! WIRKLICH! DANKE, DU ARSCHLOCH! SECURITY UND SO LÄUFT BEI DIR. wenn noch zeit ist, evtl verbessern ?>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Create'), ['class' => $reply->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>

<?
$this->registerJs(
    '$("document").ready(function(){
        $(".btn-reply").click(function(e){
            e.preventDefault();
            $(".form-reply").toggle();
        });
    });'
);
?>
