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
        ]) ?>
    </p>

    <div>
        <?= Yii::$app->user->getId() === $model->sender_id ? "An" : "Von" ?>
        <? if (Yii::$app->user->getId() === $model->sender_id) {             // Aktueller Nutzer ist Sender der Nachricht
            echo Html::a($model->receiver->fullName, '../user/' . $model->receiver->username);
        } else if (Yii::$app->user->getId() === $model->receiver_id) {       // Aktueller Nutzer ist Empfänger der Nachricht
            echo Html::a($model->sender->fullName, '../user/' . $model->sender->username);
        } ?>
    </div>

    <div>
        <?= Yii::$app->formatter->asDatetime($model->sent_at, "php:H:i:s d.m.Y") ?>
    </div>
    <div>
        <?= $model->subject ?>
    </div>
    <div>
        <?= $model->content ?>
    </div>

    <div>
        <?if (!empty($attachments)) {

            foreach ($attachments as $attachment) {
                switch ($attachment->file->extension) {
                    case "png":
                    case "jpg":
                    case "gif":
                    echo Html::img("/uploads/messattachments" . $attachment->file->path . "." . $attachment->file->extension);
                        break;
                    case "pdf":
                        echo Html::a($attachment->file->title . "." . $attachment->file->extension, "/uploads/messattachments" . $attachment->file->path . "." . $attachment->file->extension, ['target'=>'_blank']);
                        break;
                }
            }
        }
        ?>
    </div>
</div>

<?php /*
    $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'], 'action' => '/message/create']);
    $reply->subject = "Re: " . $model->subject;
    $reply->receiver_id = $model->receiver_id == Yii::$app->user->getId() ? $model->sender_id : $model->receiver_id;
    $reply->flow = $model->flow;
    ?>

    <?= $form->field($reply, 'subject')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($reply, 'content')->textarea(['rows' => 6]) ?>

    <?= $form->field($reply, 'attachment')->fileInput()->label('Anhang hinzufügen'); ?>
    <?= Html::activeHiddenInput($reply, 'flow') // TODO: DANKE YII, DASS ICH DEN SCHEIß MIT HIDDEN INPUT MACHEN MUSS! DANKE! WIRKLICH! DANKE, DU ARSCHLOCH! SECURITY UND SO LÄUFT BEI DIR. wenn noch zeit ist, evtl verbessern    ?>
    <?= Html::activeHiddenInput($reply, 'receiver_id', ['value'=>$contactID])?>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Create'), ['class' =>'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>

 */ ?>
