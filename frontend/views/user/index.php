<?php
/* @var $this yii\web\View */
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ListView;


?>
<h1>Dashboard</h1>


<?=GridView::widget([
    'dataProvider' => $messageDP,
    'columns' => [
        [
            'class' => 'yii\grid\CheckboxColumn',
        ],
        [
            'label'=> 'Von',
            'format' => 'raw',
            'value' => function($data){
                return \yii\helpers\Html::a($data->sender->firstName ." " .$data->sender->lastName, 'user?id='.$data->sender->id);
            }
        ],
        [
            'label'=> 'Betreff',
            'format' => 'raw',
            'value' => function($data){
                return Html::a($data->read?$data->subject:Html::tag('b',$data->subject), 'message/view?id=' .$data->id);
            }
        ],
        'sent_at:datetime:Datum/Uhrzeit'
    ],
    'caption' => Html::a('./message','Nachrichten')
]); ?>

<?=GridView::widget([
    'dataProvider' => $favouritesDP,
    'columns' => [
        [
            'class' => 'yii\grid\CheckboxColumn',
        ],
        'job.created_at:datetime:Erstellt am',
        'job.sector:text:Branche',
        [
            'label'=> 'Stellenbezeichnung/Beschreibung',
            'format' => 'raw',
            'value' => function($data){
                return \yii\helpers\Html::a($data->job->description, '../job/view?id=' .$data->id);
            }
        ],
    ],
    'caption' => 'Favoriten / Gespeicherte Suchen',

]); ?>


<?//=ListView::widget([
//    'dataProvider' => $favouritesDP,
//    'itemView' => '../favourites/view.php',
//    ]); ?>