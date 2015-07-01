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

    $contactID = Yii::$app->user->getId() === $model->receiver_id ? $model->sender_id : $model->receiver_id;
}
?>
<div class="message-view">

    <h1 class="headerMessageView">

        Nachricht

        <?= Yii::$app->user->getId() === $model->sender_id ? "an" : "von" ?>
        <? if (Yii::$app->user->getId() === $model->sender_id) {             // Aktueller Nutzer ist Sender der Nachricht
            echo Html::a($model->receiver->fullName, '../user/' . $model->receiver->username);
        } else if (Yii::$app->user->getId() === $model->receiver_id) {       // Aktueller Nutzer ist Empfänger der Nachricht
            echo Html::a($model->sender->fullName, '../user/' . $model->sender->username);
        } ?>


    </h1>

    <div class="buttonsMessageView">

        <? if (true) {
            // if (Yii::$app->user->getId() === $model->receiver_id) {
            echo Html::a(Yii::t('app', '<span class="glyphicon glyphicon-trash"></span>&nbsp;&nbsp;Löschen'), ['delete', 'id' => $model->id], [
                'class' => 'btn btn-default ripple',
                'data'  => [
                    'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                    'method'  => 'post',
                ],
            ]);
        } ?>

        <?= Html::a(Yii::t('app', '<span class="glyphicon glyphicon-share"></span>&nbsp;&nbsp;Antworten'), '#', [
            'class'       => 'btn btn-success',
            'data-toggle' => 'modal',
            'data-target' => '#replyModal'
//            'data'  => [
//                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
//                'method'  => 'post',
//            ],
        ]) ?>
    </div>

    <div class="senderMessageView">
        <?= Yii::$app->user->getId() === $model->sender_id ? "An" : "Von" ?>
        <? if (Yii::$app->user->getId() === $model->sender_id) {             // Aktueller Nutzer ist Sender der Nachricht
            echo Html::a($model->receiver->fullName, '../user/' . $model->receiver->username);
        } else if (Yii::$app->user->getId() === $model->receiver_id) {       // Aktueller Nutzer ist Empfänger der Nachricht
            echo Html::a($model->sender->fullName, '../user/' . $model->sender->username);
        } ?>
    </div>

    <div class="dateMessageView">
        <?= Yii::$app->formatter->asDatetime($model->sent_at, "php:H:i:s d.m.Y") ?>
    </div>

    <div class="subjectMessageView">
        <?= $model->subject ?>
    </div>

    <div class="contentMessageView">
        <?= $model->content ?>
    </div>

    <div class="attachmentMessageView">
        <? if (!empty($attachments)) {

            foreach ($attachments as $attachment) {
                switch ($attachment->file->extension) {
                    case "png":
                    case "jpg":
                    case "gif":
                    case "jpeg":
                    echo Html::img("/uploads/messattachments" . $attachment->file->path . "." . $attachment->file->extension, ['class'=>'img-responsive']);
                        break;
                    case "pdf":
                        echo Html::a($attachment->file->title . "." . $attachment->file->extension, "/uploads/messattachments" . $attachment->file->path . "." . $attachment->file->extension, ['target' => '_blank']);
                        break;
                }
            }
        }
        ?>
    </div>

    <div class="buttonsMessageView">

        <? if (true) {
            // if (Yii::$app->user->getId() === $model->receiver_id) {
            echo Html::a(Yii::t('app', '<span class="glyphicon glyphicon-trash"></span>&nbsp;&nbsp;Löschen'), ['delete', 'id' => $model->id], [
                'class' => 'btn btn-default ripple',
                'data'  => [
                    'confirm' => Yii::t('message', 'Are you sure you want to delete this item?'),
                    'method'  => 'post',
                ],
            ]);
        } ?>

        <?= Html::a(Yii::t('app', '<span class="glyphicon glyphicon-share"></span>&nbsp;&nbsp;Antworten'), '#', [
            'class'       => 'btn btn-success',
            'data-toggle' => 'modal',
            'data-target' => '#replyModal'
//            'data'  => [
//                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
//                'method'  => 'post',
//            ],
        ]) ?>
    </div>

</div>

<?php /*
    $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'], 'action' => '/message/create']);
    $reply->subject = "Re: " . $model->subject;
    $reply->receiver_id = $model->receiver_id == Yii::$app->user->getId() ? $model->sender_id : $model->receiver_id;
    $reply->flow = $model->flow;
    ?>
  */ ?>


<!-- Modal -->
<div class="modal fade" id="replyModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Antworten</h4>
            </div>
            <div class="modal-body">

                <div class="message-form form-reply form-group">

                    <?php
                    $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'], 'action' => '/message/create']);
                    $reply->subject = "Re: " . $model->subject;
                    $reply->receiver_id = $model->receiver_id == Yii::$app->user->getId() ? $model->sender_id : $model->receiver_id;
                    $reply->flow = $model->flow;
                    ?>

                    <?= $form->field($reply, 'subject', ['options' => ['class' => 'input-in-focus allowPrefill']])->textInput(['maxlength' => 255]) ?>

                    <?= $form->field($reply, 'content', ['inputOptions' => ['class' => 'form-control', 'placeholder' => 'Nachricht...']], ['options' => ['class' => 'form-control']])->textarea(['rows' => 15])->label(false) ?>


                    <?= Html::activeHiddenInput($reply, 'receiver_id') // TODO: check if exists        ?>

                    <?= $form->field($reply, 'attachment')->fileInput()->label('Anhang hinzufügen'); ?>
                    <?= Html::activeHiddenInput($reply, 'flow') ?>
                    <div class="form-group">
                    </div>

                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Schließen</button>
                <?= Html::submitButton(Yii::t('app', '<span class="glyphicon glyphicon-share"></span>&nbsp;&nbsp;Nachricht versenden'), ['class' => 'btn btn-success']) ?>

                <?php ActiveForm::end(); ?>

            </div>
        </div>
    </div>
</div>
