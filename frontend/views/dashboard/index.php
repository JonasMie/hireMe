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
use frontend\assets\CustomAppAsset;



?>

<!-- Initializing Foo Tables -->
<?    $this->registerJS(
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

    <div class="row">
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6 dashboard-tile dashboard-tile-1 tile-green"  onclick="window.location='./bewerbungen';">
            <div class="subtile subtile-left">
                <div class="tile-value tile-number">
                    <?=Html::a(42, "./bewerbungen"); //TODO: Applications?>
                </div>
                <div class="tile-value tile-string">
                    <?=Html::a('neue Bewerbungen', "./bewerbungen"); //TODO: Applications?>
                </div>
            </div>
            <div class="subtile subtile-right">

            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6 dashboard-tile dashboard-tile-2 tile-black"  onclick="window.location='./messages';">
            <div class="subtile subtile-left">
                <div class="tile-value tile-number">
                    <?=Html::a($messageDP->getCount(), "./messages");?>
                </div>
                <div class="tile-value tile-string">
                    <?=Html::a("neue Nachrichten", "./messages");?>
                </div>
            </div>
            <div class="subtile subtile-right">

            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6 dashboard-tile dashboard-tile-3 tile-green"  onclick="window.location='./jobs';">
            <div class="subtile subtile-left">
                <div class="tile-value tile-number">
                    <?=Html::a($jobDP->getCount(), './jobs')?>
                </div>
                <div class="tile-value tile-string">
                    <?=Html::a("Stellenanzeigen", './jobs')?>
                </div>
            </div>
            <div class="subtile subtile-right">

            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6 dashboard-tile dashboard-tile-4 tile-black"  onclick="window.location='./bewerbungen';">
            <div class="subtile subtile-left">
                <div class="tile-value tile-number">
                    <?=Html::a(42, "./bewerbungen"); //TODO: Applications?>
                </div>
                <div class="tile-value tile-string">
                    <?=Html::a('Bewerbungen insgesamt', "./bewerbungen"); //TODO: Applications?>
                </div>
            </div>
            <div class="subtile subtile-right">

            </div>
        </div>
    </div>


    <h2>Neueste Bewerbungen</h2>



        <table id="NewestApplicationsTable" class="table table-hover footable toggle-arrow">
            <thead>
                <tr>
                    <th></th>
                    <th>Name</th>
                    <th data-hide="phone">Stelle</th>
                    <th data-hide="xsmall,phone">Beworben am</th>
                    <th data-hide="phone">Ansehen</th>
                    <th data-toggle="true"></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td data-title="Picture"><img src="/images/tmp/user/1.jpg"></td>
                    <td data-title="Name">Tom Krug</td>
                    <td data-title="Ad">Facility Manager</td>
                    <td data-title="Date"><?= date('d'.'.'.'m'.'.'.'y') ?></td>
                    <td data-title="View"><span class="glyphicon glyphicon-eye-open"></span></td>
                    <td data-title="data-toggle"></td>
                </tr>
                <tr>
                    <td data-title="Picture"><img src="/images/tmp/user/2.jpg"></td>
                    <td data-title="Name">Stefan Humm</td>
                    <td data-title="Ad">Hostess</td>
                    <td data-title="Date"><?= date('d'.'.'.'m'.'.'.'y') ?></td>
                    <td data-title="View"><span class="glyphicon glyphicon-eye-open"></span></td>
                    <td data-title="data-toggle"></td>
                </tr>
                <tr>
                    <td data-title="Picture"><img src="/images/tmp/user/3.jpg"></td>
                    <td data-title="Name">Chris Lang</td>
                    <td data-title="Ad">Hostess</td>
                    <td data-title="Date"><?= date('d'.'.'.'m'.'.'.'y') ?></td>
                    <td data-title="View"><span class="glyphicon glyphicon-eye-open"></span></td>
                    <td data-title="data-toggle"></td>
                </tr>
                <tr>
                    <td data-title="Picture"><img src="/images/tmp/user/4.jpg"></td>
                    <td data-title="Name">Moritz Hofmann</td>
                    <td data-title="Ad">Facility Manager</td>
                    <td data-title="Date"><?= date('d'.'.'.'m'.'.'.'y') ?></td>
                    <td data-title="View"><span class="glyphicon glyphicon-eye-open"></span></td>
                    <td data-title="data-toggle"></td>
                </tr>
                <tr>
                    <td data-title="Picture"><img src="/images/tmp/user/5.jpg"></td>
                    <td data-title="Name">Cornelius Specht</td>
                    <td data-title="Ad">Taxi-Fahrer</td>
                    <td data-title="Date"><?= date('d'.'.'.'m'.'.'.'y') ?></td>
                    <td data-title="View"><span class="glyphicon glyphicon-eye-open"></span></td>
                    <td data-title="data-toggle"></td>
                </tr>
                <tr>
                    <td data-title="Picture"><img src="/images/tmp/user/6.jpg"></td>
                    <td data-title="Name">Michael Gerrrrrrrulllis</td>
                    <td data-title="Ad">MMBler</td>
                    <td data-title="Date"><?= date('d'.'.'.'m'.'.'.'y') ?></td>
                    <td data-title="View"><span class="glyphicon glyphicon-eye-open"></span></td>
                    <td data-title="data-toggle"></td>
                </tr>
                <tr>
                    <td data-title="Picture"><img src="/images/tmp/user/7.jpg"></td>
                    <td data-title="Name">Aaron Pollvogt</td>
                    <td data-title="Ad">Backend Entwickler</td>
                    <td data-title="Date"><?= date('d'.'.'.'m'.'.'.'y') ?></td>
                    <td data-title="View"><span class="glyphicon glyphicon-eye-open"></span></td>
                    <td data-title="data-toggle"></td>
                </tr>
                <tr>
                    <td data-title="Picture"><img src="/images/tmp/user/8.jpg"></td>
                    <td data-title="Name">Simön Ströbel</td>
                    <td data-title="Ad">Sparfuchs</td>
                    <td data-title="Date"><?= date('d'.'.'.'m'.'.'.'y') ?></td>
                    <td data-title="View"><span class="glyphicon glyphicon-eye-open"></span></td>
                    <td data-title="data-toggle"></td>
                </tr>

                </tbody>
            </table>





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
                    return \yii\helpers\Html::a($data->sender->firstName . " " . $data->sender->lastName, 'user/' . $data->sender->username);
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