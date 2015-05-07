<?php
/**
 * @var $this yii\web\View
 * @var $messageDP yii\data\ActiveDataProvider
 * @var $favouritesDP yii\data\ActiveDataProvider
 * @var $jobDP yii\data\ActiveDataProvider
 */

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ListView;


?>
    <h1>Dashboard</h1>

<? if (Yii::$app->user->identity->isRecruiter()): ?>

    <h1>Dashboard</h1>

    <h2>Benachrichtigungen</h2>
        <p><?=42 //TODO: Applications?> neue Bewerbungen</p>
        <p><?=$messageDP->getCount()?> neue Nachrichten</p>

    <h2>Stellenanzeigen</h2>
        <p><?=$jobDP->getCount()?> Stellenanzeigen</p>
        <p><?=42 //TODO: Applications?> Bewerbungen</p>

    <h2>Neueste Bewerbungen</h2>

<? else: ?>

    <?= GridView::widget([
        'dataProvider' => $messageDP,
        'columns'      => [
            [
                'class' => 'yii\grid\CheckboxColumn',
            ],
            [
                'label'  => 'Von',
                'format' => 'raw',
                'value'  => function ($data) {
                    return \yii\helpers\Html::a($data->sender->firstName . " " . $data->sender->lastName, 'user?id=' . $data->sender->id);
                }
            ],
            [
                'label'  => 'Betreff',
                'format' => 'raw',
                'value'  => function ($data) {
                    return Html::a($data->read ? $data->subject : Html::tag('b', $data->subject), 'message/view?id=' . $data->id);
                }
            ],
            'sent_at:datetime:Datum/Uhrzeit'
        ],
        'caption'      => Html::a('Nachrichten', './message')
    ]); ?>

    <?= GridView::widget([
        'dataProvider' => $favouritesDP,
        'columns'      => [
            [
                'class' => 'yii\grid\CheckboxColumn',
            ],
            'job.created_at:datetime:Erstellt am',
            'job.sector:text:Branche',
            [
                'label'  => 'Stellenbezeichnung/Beschreibung',
                'format' => 'raw',
                'value'  => function ($data) {
                    return \yii\helpers\Html::a($data->job->description, '../job/view?id=' . $data->id);
                }
            ],
        ],
        'caption'      => 'Favoriten / Gespeicherte Suchen',

    ]); ?>


    <? //=ListView::widget([
//    'dataProvider' => $favouritesDP,
//    'itemView' => '../favourites/view.php',
//    ]); ?>

<? endif; ?>