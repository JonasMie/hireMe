<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Message */

$this->title = $model->subject;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Messages'), 'url' => ['./message']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="message-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?//= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ])      // TODO: Antworten ?>


    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'subject:text:Betreff',
            'content:ntext:Nachricht',
            [
                'label' => 'Von',
                'format' => 'raw',
                'attribute' => function($data){
                    return \yii\helpers\Html::a($data->sender->firstName ." " .$data->sender->lastName, '../user?id='.$data->sender->id);
                }
            ],
            'sent_at:datetime:Gesendet',
        ],
    ]); ?>

</div>
