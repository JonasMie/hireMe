<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\MessageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Messages');


?>
<div class="message-index">

    <h1>Posteingang</h1>


    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', '<span class="glyphicon glyphicon-edit"></span>&nbsp;&nbsp;Neue Nachricht'), ['create'], ['class' => 'btn btn-success ripple']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel'  => $searchModel,
        'columns'      => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'class'         => 'yii\grid\CheckboxColumn',
                'filterOptions' => function () {
                    echo Html::dropDownList('action', '', ['' => 'Mark selected as: ', 'c' => 'Confirmed', 'nc' => 'No Confirmed'], ['class' => 'dropdown']);
                }
            ],
            [
                'attribute' => 'subject',
                'label'     => 'Betreff',
                'format'    => 'raw',
                'value'     => function ($data) {
                    return Html::a($data->subject, '/message/view?id=' . $data->id, ['class' => $data->read ? "read" : ""]);  // STYLE: wenn klasse 'read' => bold
                },
                'headerOptions' => ['test'=>'foo', 'data-foo'=>'bar']     // STYLE: edit headerOptions
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
                'attribute' => 'senderName',
                'label'     => 'Von/An',
                'format'    => 'raw',
                'value'     => function ($data) {
                    if (Yii::$app->user->getId() === $data->sender_id) {
                        return Html::a($data->receiver->firstName . " " . $data->receiver->lastName, '../user/' . $data->receiver->username);
                    } else if (Yii::$app->user->getId() === $data->receiver_id) {
                        return Html::a($data->sender->firstName . " " . $data->sender->lastName, '../user/' . $data->sender->username);
                    }
                },
                'headerOptions' => ['data-sender'=>'homo']
            ],
            'sent_at:datetime:Gesendet',

//            TODO: check if action column needed (rather not) --jonas
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}{delete}'
            ],
        ],
    ]); ?>


</div>
