<?php

use frontend\models\Favourites;
use yii\helpers\Html;
use yii\widgets\ListView;
use yii\grid\GridView;
use frontend\models\analytics;
use frontend\controllers\ApplicationController;

/* @var $this yii\web\View */
/* @var $model frontend\models\Job */

$this->title = "Stellenanzeigen";
$inFavourites = \frontend\models\Favourites::find()->where(['job_id' => $provider->id, 'user_id' => Yii::$app->user->getId()])->count() > 0;
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

<?

?>

    <div class="myjobs">

        <? if (!(Yii::$app->user->identity->isRecruiter())) {
            if (!($inFavourites)) {
                echo('<div class="favouriteAlert"></div>');
            }
        }
        ?>


        <h1><?= Html::encode($this->title) ?></h1>

        <? if (Yii::$app->user->identity->isRecruiter()): ?>

            <?=
            ListView::widget([
                'dataProvider' => $provider,
                'itemView'     => function ($data) {
                    return $this->render('jobItem', [
                        'model'       => $data,
                        'subProvider' => ApplicationController::getApplicationDataForJob($data['id']),

                    ]);
                }
            ]);
            ?>
            <?= Html::decode("<a href='/job/create'><button>Neue Stellenanzeige</button></a>") ?>
            <?= GridView::widget([
                'id'           => 'jobList',
                'tableOptions' => ['class' => 'hireMeTable footable toggle-arrow', 'id' => 'inboxTable'],
                'dataProvider' => $provider,
                'columns'      => [
                    [
                        'class'         => 'yii\grid\CheckboxColumn',
                        'filterOptions' => function () {
                            echo Html::dropDownList('action', '', ['' => 'Mark selected as: ', 'c' => 'Confirmed', 'nc' => 'No Confirmed'], ['class' => 'dropdown']);
                        }
                    ],
                    'title:text:Titel',
                    'job_begin:text:Job beginnt',
                    [

                        'label'  => 'Info',
                        'format' => 'raw',
                        'value'  => function ($data) {
                            return \yii\helpers\Html::encode("Bewerber: " . count(Analytics::getAppliesForJob($data->id))) . " - " . \yii\helpers\Html::a("Analytics", "/analytics/detail?id=" . $data->id);
                        }
                    ],
                    [
                        'label'  => 'Actions',
                        'format' => 'raw',
                        'value'  => function ($data) {

                            return Html::a(Yii::t('app', '<span class="glyphicon glyphicon-edit"></span>&nbsp;&nbsp;Bearbeiten'), ['update-job', 'id' => $data->id], ['class' => 'btn btn-success ripple btn-editJob']) . " " . Html::a(Yii::t('app', '<span class="glyphicon glyphicon-edit"></span>&nbsp;&nbsp;Anschauen'), ['view', 'id' => $data->id], ['class' => 'btn btn-primary ripple btn-viewJob']);
                        }


                    ],

                ],
                'caption'      => Html::decode("<a href='/job/create'><button>Neue Stellenanzeige</button></a>")
            ]);
            ?>


        <? else: ?>
            <?= GridView::widget([
                'dataProvider' => $provider,
                'tableOptions' => ['class' => 'hireMeTable footable toggle-arrow', 'id' => 'jobListTable'],
                'columns'      => [
                    [
                        'attribute'      => 'title',
                        'value'          => function ($data) {
                            return Html::a($data['title'], ['/job/view', 'id' => $data["id"]]);
                        },
                        'format'         => 'raw',
                        'label'          => 'Bezeichnung',
                        'headerOptions'  => ['class' => 'first-col'],
                        'contentOptions' => ['class' => 'first-col'],
                    ],
                    [
                        'attribute'      => 'job_begin',
                        'label'          => 'Verfügbar ab',
                        'format'         => 'date',
                        'value'          => 'job_begin',
                        'headerOptions'  => ['class' => 'second-col'],
                        'contentOptions' => ['class' => 'second-col'],
                    ],
                    [
                        'attribute'      => 'distance',
                        'value'          => function ($data) {
                            return round($data["distance"]) . " km";
                        },
                        'label'          => 'Entfernung',
                        // only show column is user has set his personal plz (otherwise no distance computation possible)
                        'visible'        => isset(Yii::$app->user->identity->geo_id),
                        'headerOptions'  => ['class' => 'third-col', 'data-hide' => 'mediaXXsmall,phone'],
                        'contentOptions' => ['class' => 'third-col'],
                    ],
                    [
                        'attribute'      => 'city',
                        'label'          => 'Stadt',
                        'headerOptions'  => ['class' => 'fourth-col', 'data-hide' => 'mediaXXsmall,phone'],
                        'contentOptions' => ['class' => 'fourth-col'],
                    ],
                    [
                        'class'          => \yii\grid\ActionColumn::className(),
                        'buttons'        =>
                            [
                                'view' => function ($url, $model, $key) {
                                    return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', 'job/view?id=' . $model["id"], ['title' => Yii::t('app', 'Ansehen')]);
                                },
                            ],
                        'template'       => '{view}',
                        'headerOptions'  => ['class' => 'fifth-col', 'data-hide' => 'mediaXXsmall,phone'],
                        'contentOptions' => ['class' => 'fifth-col'],
                    ],

                    [
                        'class'          => \yii\grid\ActionColumn::className(),
                        'buttons'        =>
                            [
                                'update' => function ($url, $model, $key) {
                                    if (Favourites::find()->where(['job_id' => $model["id"], 'user_id' => Yii::$app->user->getId()])->count() == 0) {
                                        return Html::a('<span class="glyphicon glyphicon-star"></span>', '#', ['title' => Yii::t('app', 'Zu Favoriten hinzufügen'),'data-job' => $model["id"], 'id' =>"toggleFavourite"]);
                                    } else return '';
                                }
                            ],
                        'template'       => '{update}',
                        'headerOptions'  => ['class' => 'sixth-col', 'data-hide' => 'mediaXXsmall,phone'],
                        'contentOptions' => ['class' => 'sixth-col'],
                    ],

                    [

                        'class'          => 'yii\grid\Column',
                        'headerOptions'  => ['data-toggle' => 'true'],
                        'contentOptions' => ['data-title' => 'data-toggle', 'class' => 'seventh-col'],

                    ],
                ],
            ]);
            ?>

            <div class="dropdown" id="searchDistance">
                <button id="dLabel" type="button" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false"
                        class="btn btn-success" <? if (!isset(Yii::$app->user->identity->geo_id)) echo "disabled" ?>>
                    Nach Umkreis suchen
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu" aria-labelledby="dLabel">
                    <li class="bulkDelete">
                        <a href="/job?dist=10" tabindex="-1">10 km</a>
                        <a href="/job?dist=20" tabindex="-1">20 km</a>
                        <a href="/job?dist=30" tabindex="-1">30 km</a>
                        <a href="/job?dist=50" tabindex="-1">50 km</a>
                        <a href="/job?dist=100" tabindex="-1">100 km</a>
                        <a href="/job?dist=200" tabindex="-1">200 km</a>
                    </li>
                </ul>
            </div>
        <? endif; ?>
    </div>

<? // TODO: message if error
$this->registerJs("jQuery('#toggleFavourite').click(function (e) {e.preventDefault(); \$this = jQuery(this);jQuery.post('/favourites/toggle', {id: \$this.data('job')}, function (res) {if (res.success) {\$this.remove();jQuery('.favouriteAlert').html('<div class=\"alert alert-success alert-dismissible\" role=\"alert\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>Der Job wurde deinen Favoriten hinzugefügt. <a href=\"#\" class=\"alert-link\">Hier kannst du deine Favoriten ansehen.</a></div>')} else {\$this.remove();}});});");
?>