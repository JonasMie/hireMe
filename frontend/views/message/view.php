<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Message */

$this->title = $model->subject;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Messages'), 'url' => ['./message']];
$this->params['breadcrumbs'][] = $this->title;

if($model->receiver_id === Yii::$app->user->getId()){
    $model->read=1;
    $model->save();
}
?>
<div class="message-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <? //= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data'  => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method'  => 'post',
            ],
        ])      // TODO: Antworten    ?>


    </p>

    <?
    $attributes = [
        'subject:text:Betreff',
        'content:html:Nachricht',
        [
            'label'     => 'Von',
            'format'    => 'raw',
            'attribute' => function ($data) {
                return \yii\helpers\Html::a($data->sender->firstName . " " . $data->sender->lastName, '../user/' . $data->sender->username);
            }
        ],
        'sent_at:datetime:Gesendet'];
    if (!empty($model->messageAttachments)) {           // TODO: check multiple attachments
        foreach ($model->messageAttachments as $attachment) {
            switch ($attachment->file->extension) {     // TODO: check file paths
                case "png":
                case "jpg":
                case "gif":
                    array_push($attributes, [
                        'attribute' => 'Anhänge',
                        'value'     => Yii::getAlias('@app') . $attachment->file->path . "." . $attachment->file->extension,
                        'format'    => ['image', ['width' => '100', 'height' => '100']],
                    ]);
                    break;
                case "pdf":
                    array_push($attributes, [
                        'label'     => 'Anhänge',
                        'attribute' => function () use ($attachment) {
                            return Html::a($attachment->file->title, Yii::$app->basePath . $attachment->file->path . "." . $attachment->file->extension);
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
