<?php

use yii\bootstrap\Dropdown;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\MessageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Messages');
\frontend\assets\BulkAction::register($this);

?>

<!-- Initializing Foo Tables -->
<? $this->registerJS(
    "$(function () {
        $('.footable').footable({
            breakpoints: {
                /* Somehow Footable misses the screen wdtdh by 31 Pixels */
                mediaXXsmall: 480,
                mediaXsmall: 736,
                mediaSmall: 960

            }
        });
    });");

?>

<div class="message-index">

    <h1>Posteingang</h1>


    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', '<span class="glyphicon glyphicon-edit"></span>&nbsp;&nbsp;Neue Nachricht'), ['create'], ['class' => 'btn btn-success ripple btn-newMessage']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel'  => $searchModel,
        'tableOptions' => ['class' => 'hireMeTable footable toggle-arrow', 'id' => 'inboxTable'],
        'rowOptions'   => function ($model) {
            $role = $model->receiver_id == Yii::$app->user->getId()?'receiver':'sender;';

            if ($model->read == 0 && $model->receiver_id == Yii::$app->user->getId())
                return ['class' => 'unread ' .$role];
            return ['class' => $role];

        },
        'columns'      => [
            [
                'class'          => 'yii\grid\CheckboxColumn',
                'filterOptions'  => function () {
                    echo Html::dropDownList('action', '', ['' => 'Mark selected as: ', 'c' => 'Confirmed', 'nc' => 'No Confirmed'], ['class' => 'dropdown']);
                },
                'headerOptions'  => ['class' => 'first-col'],
                'contentOptions' => ['class' => 'first-col']
            ],
            [
                'attribute'      => 'subject',
                'label'          => 'Betreff',
                'format'         => 'raw',
                'value'          => function ($data) {
                    return Html::a($data->subject, '/message/view?id=' . $data->id, ['class' => $data->read ? "read" : ""]);  // STYLE: wenn klasse 'read' => bold
                },

                'headerOptions'  => ['class' => 'second-col'],
                'contentOptions' => ['class' => 'second-col']

            ],
//            TODO: check if content needed in overview? if so, use ellipsis to shorten content --jonas
//            [
//                'attribute' => 'content',
//                'label' => 'Nachricht',
//                'format' => 'raw',
//                'value' => function($data){
//                    return Html::a($data->content, '/message/view?id=' .$data->id, ['class'=>$data->read?"read":""]);
//                }
//            ],
            [
                'attribute'      => 'senderName',
                'label'          => 'Von/An',
                'format'         => 'raw',
                'value'          => function ($data) {
                    if (Yii::$app->user->getId() === $data->sender_id) {
                        return Html::a($data->receiver->getProfilePicture(true) . '<div class="message-sender">' . $data->receiver->firstName . " " . $data->receiver->lastName . '</div>', '../user/' . $data->receiver->username);
                    } else if (Yii::$app->user->getId() === $data->receiver_id) {
                        return Html::a($data->sender->getProfilePicture(true) . '<div class="message-sender">' . $data->sender->firstName . " " . $data->sender->lastName . '</div>', '../user/' . $data->sender->username);
                    }
                },
                'headerOptions'  => ['class' => 'third-col', 'data-hide' => 'mediaXXsmall,phone'],
                'contentOptions' => ['class' => 'third-col']

            ],
            [
                'attribute'      => 'sent_at',
                'format'         => 'datetime',
                'label'          => 'Gesendet',
                'headerOptions'  => ['class' => 'fourth-col', 'data-hide' => 'mediaSmall,phone,mediaXsmall'],
                'contentOptions' => ['class' => 'fourth-col']


            ],
//            TODO: check if action column needed (rather not) --jonas
            [
                'class'          => 'yii\grid\ActionColumn',
                'template'       => '{view}{delete}',
                'headerOptions'  => ['class' => 'fifth-col', 'data-hide' => 'mediaXsmall,phone'],
                'contentOptions' => ['class' => 'fifth-col']

            ],
            [

                'class'          => 'yii\grid\Column',
                'headerOptions'  => ['data-toggle' => 'true'],
                'contentOptions' => ['data-title' => 'data-toggle', 'class' => 'sixth-col']

            ],
        ],
    ]); ?>


    <p>
        <?= Html::a(Yii::t('app', '<span class="glyphicon glyphicon-edit"></span>&nbsp;&nbsp;Neue Nachricht'), ['create'], ['class' => 'btn btn-success ripple btn-newMessage btn-newMessageSecond']) ?>
    </p>


</div>

<div class="dropdown" id="bulkActions">
    <button id="dLabel" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Aktion
        <span class="caret"></span>
    </button>
    <ul class="dropdown-menu" aria-labelledby="dLabel">
        <li class="bulkRead">
            <a href="#" tabindex="-1">Als gelesen markieren</a>
        </li>
        <li class="bulkUnread">
            <a href="#" tabindex="-1">Als ungelesen markieren</a>
        </li>
        <li class="bulkDelete">
            <a href="#" tabindex="-1">Löschen</a>
        </li>
    </ul>
</div>
