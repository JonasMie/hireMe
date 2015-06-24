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

\frontend\assets\BulkAction::register($this);
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

    <h2><a class="userDashboardMessagesHeader" href="/message">Nachrichten</a></h2>

    <?= GridView::widget([
        'dataProvider' => $messageDP,
        'tableOptions' => [
            'class' => 'table table-hover footable toggle-arrow hireMeTable',
            'id'    => 'DashboardMessages',
        ],
        'options' => [
            'data-type' => 'message',
            'class' => 'grid-view'
        ],
        'columns'      => [
            [
                'class'  => 'yii\grid\CheckboxColumn',
                'footer' =>

                    '<div class="dropdown" id="bulkActions">
        <a href="#" id="dLabel" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Aktion
            <span class="caret"></span>
        </a>
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
    </div>',
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
                'attribute'      => 'sent_at',
                'format'         => 'text',
                'label'          => 'Gesendet',
                'value'          => function ($data) {
                    return \frontend\helper\Setup::verboseDate($data->sent_at);
                },
                'headerOptions' => ['data-hide' => 'xsmall,phone'],
            ],
            [
                'class'          => 'yii\grid\Column',
                'headerOptions'  => ['data-toggle' => 'true'],
                'contentOptions' => ['data-title' => 'data-toggle']
            ],
        ],
        'showFooter'   => true,
    ]); ?>

    <h2><a class="userDashboardFavoritesHeader" href="/favourites">Favoriten</a></h2>


    <?= GridView::widget([
        'dataProvider' => $favouritesDP,
        'tableOptions' => [
            'class' => 'table table-hover footable toggle-arrow hireMeTable',
            'id'    => 'DashboardFavorites',
        ],
        'options' => [
            'data-type' => 'favourites',
            'class' => 'grid-view'
        ],
        'columns'      => [
            [
                'class'  => 'yii\grid\CheckboxColumn',
                'footer' =>
                    '<div class="dropdown" id="bulkActions">
                        <button id="dLabel" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Aktion
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dLabel">
                            <li class="bulkDelete">
                                <a href="#" tabindex="-1">Löschen</a>
                            </li>
                        </ul>
                    </div>'
            ],
            [
                'attribute' => 'jobDescription',
                'label'     => 'Job',
                'format'    => 'raw',
                'value'     => function ($data) {
                    return Html::a($data->job->description, ['/job/view', 'id' => $data->job->id]);
                },
            ],
            [
                'attribute' => 'company',
                'label'     => 'Unternehmen',
                'format'    => 'raw',
                'value'     => function ($data) {
                    return Html::a($data->job->company->name, ['/company/view', 'id' => $data->job->company->id]);
                },
            ],
            [
                'attribute'     => 'jobBegin',
                'format'        => 'date',
                'label'         => 'Verfügbar ab',
                'value'         => function ($data) {
                    return Yii::$app->formatter->asDate($data->job->job_begin, "php: d.m.Y");
                },
                'headerOptions' => ['data-hide' => 'xsmall,phone'],

            ],
            [

                'class'          => 'yii\grid\Column',
                'headerOptions'  => ['data-toggle' => 'true'],
                'contentOptions' => ['data-title' => 'data-toggle']

            ],
        ],
        'showFooter' => true,
    ]); ?>



<? endif; ?>