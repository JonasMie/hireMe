<?php
/**
 * @var $this yii\web\View
 * @var $messageDP yii\data\ActiveDataProvider
 * @var $favouritesDP yii\data\ActiveDataProvider
 * @var $jobDP yii\data\ActiveDataProvider
 * @var $applicationProvider yii\data\ActiveDataProvider
 * @var $newApplications Integer
 * @var $totalApplications Integer
 */

use yii\grid\GridView;
use yii\helpers\Html;


?>

    <!-- Initializing Foo Tables -->
<? $this->registerJS(
    "$(function () {
        $('.footable').footable({
            breakpoints: {
                xsmall: 736 /* Somehow Footable misses the screen wdtdh by 31 Pixels */
            }
        });
    });");

?>

    <h1>Willkommen</h1>

<? if (Yii::$app->user->identity->isRecruiter()): ?>


    <!-- TILES -->
    <div class="row">
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6 dashboard-tile dashboard-tile-1 tile-green"
             onclick="window.location='./application/index?new=true';">

            <div class="subtile subtile-left">
                <div class="tile-value tile-number">
                    <?= Html::a($newApplications, "/application/index?new=true"); ?>
                </div>
                <div class="tile-value tile-string">
                    <?= Html::a('neue Bewerbungen', "/application/index?new=true"); ?>
                </div>
            </div>
            <div class="subtile subtile-right">

            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6 dashboard-tile dashboard-tile-2 tile-black ripple"
             onclick="window.location='/message';">
            <div class="subtile subtile-left">
                <div class="tile-value tile-number">
                    <?= Html::a($messages, "/message"); ?>
                </div>
                <div class="tile-value tile-string">
                    <?= Html::a("neue Nachrichten", "/message"); ?>
                </div>
            </div>
            <div class="subtile subtile-right">

            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6 dashboard-tile dashboard-tile-3 tile-green ripple"
             onclick="window.location='./job';">
            <div class="subtile subtile-left">
                <div class="tile-value tile-number">
                    <?= Html::a(count($jobs), '/job') ?>
                </div>
                <div class="tile-value tile-string">
                    <?= Html::a("Stellenanzeigen", '/job') ?>
                </div>
            </div>
            <div class="subtile subtile-right">

            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6 dashboard-tile dashboard-tile-4 tile-black"
             onclick="window.location='./application';">

            <div class="subtile subtile-left">
                <div class="tile-value tile-number">
                    <?= Html::a($totalApplications, "/application"); ?>
                </div>
                <div class="tile-value tile-string">
                    <?= Html::a('Bewerbungen insgesamt', "/application"); ?>
                </div>
            </div>
            <div class="subtile subtile-right">

            </div>
        </div>
    </div>
    <!-- END TILES -->

    <!-- TABLE -->
    <h2>Neueste Bewerbungen</h2>

    <?= GridView::widget([
        'dataProvider' => $applicationProvider,
        //    'filterModel'  => $searchModel,
        'tableOptions' => [
            'class' => 'table table-hover footable toggle-arrow hireMeTable',
            'id'    => 'NewestApplicationsTable',
        ],
        'columns'      => [
            [
                'attribute'      => 'picture',
                'format'         => 'raw',
                'value'          => function ($data) {
                    return $data->user->getProfilePicture(true);
                },
                'contentOptions' => ['data-title' => 'Picture'],
                'label'          => false
            ],
            [
                'attribute'      => 'user',
                'label'          => 'Name',
                'format'         => 'raw',
                'value'          => function ($data) {
                    return Html::a($data->user->fullName, '../user/' . $data->user->username);
                },
                'contentOptions' => ['data-title' => 'Name'],
            ],
            [
                'attribute'      => 'job',
                'label'          => 'Stelle',
                'format'         => 'raw',
                'value'          => function ($data) {
                    return Html::a($data->job->title, '../job/' . $data->job->title);
                },
                'headerOptions'  => ['data-hide' => 'phone'],
                'contentOptions' => ['data-title' => 'Ad'],
            ],
            [
                'attribute'      => 'created_at',
                'label'          => 'Beworben am',
                'format'         => ['date', 'php:d.m.Y'],
                'headerOptions'  => ['data-hide' => 'xsmall,phone'],
                'contentOptions' => ['data-title' => 'Date']
            ],
            [
                'class'          => 'yii\grid\ActionColumn',
                'template'       => '{view}',
                'headerOptions'  => ['data-hide' => 'phone'],
                'contentOptions' => ['data-title' => 'View'],
            ],
            [

                'class'          => 'yii\grid\Column',
                'headerOptions'  => ['data-toggle' => 'true'],
                'contentOptions' => ['data-title' => 'data-toggle']

            ],

        ]
    ]);
    ?>


<? else: ?>

    <h2><a class="userDashboardMessagesHeader" href="./message">Nachrichten</a></h2>

    <?= GridView::widget([
        'dataProvider' => $messageDP,
        'tableOptions' => [
            'class' => 'table table-hover footable toggle-arrow hireMeTable',
            'id'    => 'DashboardMessages',
        ],
        'columns'      => [
            [
                'class' => 'yii\grid\CheckboxColumn',
            ],
            [
                'label'  => 'Betreff',
                'format' => 'raw',
                'value'  => function ($data) {
                    return Html::a($data->read ? $data->subject : Html::tag('b', $data->subject), 'message/view?id=' . $data->id);
                }
            ],
            [
                'attribute'     => 'senderName',
                'label'         => 'Von/An',
                'format'        => 'raw',
                'value'         => function ($data) {
                    if (Yii::$app->user->getId() === $data->sender_id) {
                        return Html::a($data->receiver->getProfilePicture(true) . '<div class="message-sender">' . $data->receiver->firstName . " " . $data->receiver->lastName . '</div>', '../user/' . $data->receiver->username);
                    } else if (Yii::$app->user->getId() === $data->receiver_id) {
                        return Html::a($data->sender->getProfilePicture(true) . '<div class="message-sender">' . $data->sender->firstName . " " . $data->sender->lastName . '</div>', '../user/' . $data->sender->username);
                    }
                },
                'headerOptions' => ['data-hide' => 'phone'],
                
            ],
            [
                'attribute'     => 'sent_at',
                'format'        => 'datetime',
                'label'         => 'Gesendet/Empfangen',
                'headerOptions' => ['data-hide' => 'xsmall,phone'],

            ],
            [

                'class'          => 'yii\grid\Column',
                'headerOptions'  => ['data-toggle' => 'true'],
                'contentOptions' => ['data-title' => 'data-toggle']

            ],
        ],
        //'caption'      => Html::a('Nachrichten', './message')
    ]); ?>

    <h2 class="userDashboardFavoritesHeader">Favoriten / Gespeicherte Suchen</h2>


    <?= GridView::widget([
        'dataProvider' => $favouritesDP,
        'tableOptions' => [
            'class' => 'table table-hover footable toggle-arrow hireMeTable',
            'id'    => 'DashboardFavorites',
        ],
        'columns'      => [
            [
                'class' => 'yii\grid\CheckboxColumn',
            ],
            [
                'label'  => 'Stellenbezeichnung',
                'format' => 'raw',
                'value'  => function ($data) {
                    return \yii\helpers\Html::a($data->job->description, '../job/view?id=' . $data->id);
                }
            ],
            /*
            [
                'attribute' => 'sector',
                'format' => 'datetime',
                'label' => 'Branche',
                'headerOptions'  => ['data-hide' => 'phone'],

            ],
            [
                'attribute' => 'created_at',
                'format' => 'datetime',
                'label' => 'Erstellt am',
                'headerOptions'  => ['data-hide' => 'xsmall,phone'],

            ],
            */
            [

                'class'          => 'yii\grid\Column',
                'headerOptions'  => ['data-toggle' => 'true'],
                'contentOptions' => ['data-title' => 'data-toggle']

            ],
        ],
        //'caption'      => 'Favoriten / Gespeicherte Suchen',
    ]); ?>


    <? //=ListView::widget([
//    'dataProvider' => $favouritesDP,
//    'itemView' => '../favourites/view.php',
//    ]); ?>

<? endif; ?>