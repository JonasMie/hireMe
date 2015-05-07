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
                'label' => 'Betreff',
                'format' => 'raw',
                'value' => function($data){
                    return Html::a($data->read?$data->subject:Html::tag('b',$data->subject), 'message/view?id=' .$data->id);
                }
            ],
            [
                'label' => 'Nachricht',
                'format' => 'raw',
                'value' => function($data){
                    return Html::a($data->read?$data->content:Html::tag('b',$data->content), 'message/view?id=' .$data->id);
                }
            ],
            [
                'label' => 'Von',
                'format' => 'raw',
                'value' => function($data){
                    return Html::a($data->sender->firstName ." " .$data->sender->lastName, '../user?id='.$data->sender->id);
                }
            ],
            'sent_at:datetime:Gesendet',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
