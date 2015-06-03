<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\MessageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Messages');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="message-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Neue Nachricht verfassen'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            ['class' => 'yii\grid\CheckboxColumn'],
            [
                'attribute' => 'subject',
                'label' => 'Betreff',
                'format' => 'raw',
                'value' => function($data){
                    return Html::a($data->subject, '/message/view?id=' .$data->id, ['class'=>$data->read?"read":""]);  // STYLE: wenn klasse 'read' => bold
                }
            ],
            [
                'attribute' => 'content',
                'label' => 'Nachricht',
                'format' => 'raw',
                'value' => function($data){
                    return Html::a($data->content, '/message/view?id=' .$data->id, ['class'=>$data->read?"read":""]);
                }
            ],
            [
                'attribute' => 'senderName',
                'label' => 'Von',
                'format' => 'raw',
                'value' => function($data){
                    return Html::a($data->sender->firstName ." " .$data->sender->lastName, '../user/'.$data->sender->username);
                }
            ],
            'sent_at:datetime:Gesendet',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
