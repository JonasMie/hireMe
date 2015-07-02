<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Company */
/* @var $jobDP yii\data\ActiveDataProvider */


include Yii::getAlias('@helper/companySignup.php');;

$this->title = $model->name;
?>

<!-- Initializing Foo Tables -->
<? $this->registerJS(
    "$(function () {
        $('.footable').footable({
            breakpoints: {
                /* Somehow Footable misses the screen width by 31 Pixels */
                mediaXXsmall: 480,
                mediaXsmall: 736,
                mediaSmall: 960

            }
        });
    });");
?>

<div class="company-view">

    <h1><?= Html::encode($this->title) ?></h1>


    <div class="row">
        <div class="company-street col-sm-4 col-md-4 col-lg-4">
            <h2>Anschrift</h2>
            <b><?= $model->street ?>&nbsp;<?= $model->houseno ?></b>
            <br>
            <?= $model->zip ?>&nbsp;<?= $model->city ?>
        </div>

        <div class="company-sector col-sm-4 col-md-4 col-lg-4">
            <h2>Branche</h2>
            <?= $sectorList[$model->sector] ?>
        </div>

        <div class="company-employee-amaount col-sm-4 col-md-4 col-lg-4">
            <h2>Anzahl der Beschäftigten:</h2>
            <?= $employeeAmount[$model->employeeAmount] ?>
        </div>
    </div>

    <h2 class="table-header">Stellenanzeigen</h2>

    <?=
    \yii\grid\GridView::widget([
        'dataProvider' => $jobDP,
        'tableOptions' => ['class' => 'hireMeTable footable toggle-arrow', 'id' => 'companyTable'],
        'columns' => [
            [
                'attribute' => 'title',
                'format' => 'raw',
                'headerOptions'  => ['class' => 'first-col'],
                'contentOptions' => ['class' => 'first-col'],
                'value' => function ($data) {
                    return Html::a($data->title, ['/job/view', 'id' => $data->id]);
                }
            ],
            [
                'attribute' => 'job_begin',
                'format' => 'date',
                'headerOptions'  => ['class' => 'second-col', 'data-hide' => 'mediaXsmall,phone'],
                'contentOptions' => ['class' => 'second-col'],
            ],
            [
                'attribute' => 'job_end',
                'format' => 'date',
                'headerOptions'  => ['class' => 'third-col', 'data-hide' => 'mediaXsmall,phone'],
                'contentOptions' => ['class' => 'third-col']
            ],
            [
                'attribute' => 'city',
                'headerOptions'  => ['class' => 'fourth-col', 'data-hide' => 'mediaXXsmall,phone'],
                'contentOptions' => ['class' => 'fourth-col']
            ],
            // TODO: include is only available in global scope.. got no idea how to access it in method call
//            [
//                'attribute' => 'sector',
//                'value' => function($data){
//                    return $sectorList[$data->sector];
//                }
//            ]
            [

                'class' => 'yii\grid\Column',
                'headerOptions' => ['data-toggle' => 'true', 'class' => 'fifth-col'],
                'contentOptions' => ['data-title' => 'data-toggle', 'class' => 'fifth-col']

            ],
        ]
    ])
    ?>
</div>