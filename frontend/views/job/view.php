<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use frontend\models\Application;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Job */
include Yii::getAlias('@helper/companySignup.php');
$GLOBALS['sectorList'] = $sectorList;
$this->title = 'Stellenanzeige';

?>
    <div class="job-view">

        <h1><?= Html::encode($this->title) ?></h1>

        <? /* View as Recruiter */ ?>

        <?
        //    if (Yii::$app->user->identity->isRecruiter()){
        //
        //		echo Html::a(Yii::t('app', 'Update'), ['update-job', 'id' => $model->id], ['class' => 'btn btn-primary']);
        //		echo Html::a(Yii::t('app', 'Delete'), ['delete-job', 'id' => $model->id], [
        //			'class' => 'btn btn-danger',
        //			'data'  => [
        //				'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
        //				'method'  => 'post',
        //			],
        //		]);
        //
        //	} ?>

        <? /* View Job Detail as User and Recruiter */ ?>

        <div class="row">
            <div class="col-sm-12">
                <h2><?= ($model->title) ?></h2>
            </div>
        </div>

        <div class="row">

            <div class="col-sm-7">

                <? if (Application::existsApplicationFromUser(Yii::$app->user->identity->id, $model->id) == true): ?>
                    <? switch (Application::getApplicationStatByUserAndJob(Yii::$app->user->identity->id, $model->id)) {
                        case "Gespeichert":
                            echo(
                            '<div class="alert alert-success alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    Du hast bereits eine Bewerbung für diese Stellenanzeige erstellt.
                                    <a href="#" class="alert-link">Hier kannst du sie bearbeiten.</a>
                                </div>'
                            );
                            break;
                        case "Versendet":
                            echo(
                            '<div class="alert alert-success alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    Du hast dich bereits auf diese Stellenanzeige beworben.
                                    <a href="#" class="alert-link">Hier kannst du deine Bewerbung ansehen.</a>
                                </div>'
                            );
                            break;
                        case "Vorstellungsgespräch":
                            echo(
                                '<div class="alert alert-success alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    Herzlichen Glückwunsch! Du wurdest bereits zu einem Bewerbungsgespräch zu dieser Stelle eingeladen.
                                </div>'
                            );
                            break;
                        case "Absage":
                            echo(
                                '<div class="alert alert-warning alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    Schade, bei dieser Bewerbung hat es nicht geklappt. Kein Problem, ein passendes Unternehmen
                                    <a href="#" class="alert-link">wartet schon auf dich!</a>
                                </div>'
                            );
                            break;
                    }
                    ?>

                <? endif; ?>

                <div class="row">
                    <div class="col-sm-12"><h3>Beschreibung</h3></div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <?= ($model->description) ?>
                    </div>
                    <div class="col-sm-12 apply">
                        <? if (!(Yii::$app->user->identity->isRecruiter())) {
                            $inFavourites = \frontend\models\Favourites::find()->where(['job_id' => $model->id, 'user_id' => Yii::$app->user->getId()])->count() > 0;

                            if ($inFavourites) {
                                $label = "<span class='glyphicon glyphicon-remove'></span>&nbsp;&nbsp;Aus Favoriten entfernen";
                                $class = "remove btn-default";
                            } else {
                                $label = "<span class='glyphicon glyphicon-star'></span>&nbsp;&nbsp;Als Favorit speichern";
                                $class = "add btn-default";
                            }
                            echo Html::a($label, '#', ['data-job' => $model->id, 'class' => $class . ' btn ripple', 'id' => 'toggleFavourite']);
                            if (Application::existsApplicationFromUser(Yii::$app->user->identity->id, $model->id) == false) {
                                echo Html::a("Jetzt bewerben", "/job/apply-intern?id=" . $model->id, ['class' => 'btn btn-success ripple']);
                            }
                        } ?>
                    </div>
                </div>
            </div>

            <div class="col-sm-5">
                <div class="row">
                    <div class="col-sm-12">
                        <h3>Unternehmen</h3>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <p>

                        <h3 class="highlight"><?= Html::a($model->company->name, ['/company/view', 'id' => $model->company_id]) ?></h3></p>
                        <?= DetailView::widget([
                            'model'      => $model,
                            'options'    => [
                                'class' => 'detail-view',
                            ],
                            'attributes' => [
                                [
                                    'label' => 'Branche',
                                    'value' => $GLOBALS['sectorList'][$model->sector],
                                ],
                                [
                                    'label' => 'Standort',
                                    'value' => $model->zip . ', ' . $model->city,
                                ],
                                /* TODO: Arbeitszeit = Vollzeit, Praktikum, ...
                                [
                                    'label' => 'Arbeitszeit',
                                    'value' => $model->time:datetime,
                                ],
                                */
                            ],
                        ])
                        ?>
                        <p><h4>Weitere Informationen</h4></p>
                        <?= DetailView::widget([
                            'model'      => $model,
                            'options'    => [
                                'class' => 'detail-view',
                            ],
                            'attributes' => [
                                [
                                    'label' => 'Datum',
                                    'value' => $model->created_at,
                                ],
                                [
                                    'label'  => 'Verfügbar ab',
                                    'format' => 'date',
                                    'value'  => $model->job_begin,
                                ],
                                [
                                    'label'  => 'Befristet bis',
                                    'format' => 'date',
                                    'value'  => $model->job_end,
                                ],
                            ],
                        ])
                        ?>
                    </div>
                </div>

            </div>

        </div>

        <div class="row">

            <? /* View Job Detail as User and Recruiter End */ ?>

            <? /* View as Recruiter */ ?>

            <? if (Yii::$app->user->identity->isRecruiter()): ?>
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'tableOptions' => ['class' => 'hireMeTable footable toggle-arrow', 'id' => 'inboxTable'],
                    'columns'      => [
                        ['class' => 'yii\grid\SerialColumn'],
                        'key:ntext',
                        'site:ntext',
                        [
                            'class'    => 'yii\grid\ActionColumn',
                            'template' => '{update}{delete}',
                        ],
                    ],
                    'caption'      => Html::a("Neuen Key generieren", '/job/create-btn?id=' . $model->id),
                ]); ?>

                <? /* View as Recruiter End */ ?>

            <? endif; ?>
        </div>
    </div>

<? // TODO: message if error
$this->registerJs("jQuery('#toggleFavourite').click(function (e) {e.preventDefault(); \$this = jQuery(this);jQuery.post('/favourites/toggle', {id: \$this.data('job')}, function (res) {if (res.success) {\$this.removeClass('add remove').addClass(res.type);if (res.type == 'add') {\$this.html('<span class=\'glyphicon glyphicon-star\'></span>&nbsp;&nbsp;Als Favorit speichern');} else {\$this.html('<span class=\'glyphicon glyphicon-remove\'></span>&nbsp;&nbsp;Aus Favoriten entfernen');}} else {return;}});});");
?>