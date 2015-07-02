<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\CompanySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('company', 'Company');
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

<div class="company-index">

    <h1><?= Html::encode($this->title) ?></h1>


    <? include Yii::getAlias('@helper/companySignup.php');
    $GLOBALS['sectors'] = $sectorList;
    $GLOBALS['employees'] = $employeeAmount; ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions' => ['class' => 'hireMeTable footable toggle-arrow', 'id' => 'companyOverviewTable'],
        'emptyCell'    => '&nbsp;',
        'columns'      => [
            [
                'attribute' => 'name',
                'format'    => 'raw',
                'headerOptions'  => ['class' => 'first-col'],
                'contentOptions' => ['class' => 'first-col'],
                'value'     => function ($data) {
                    return Html::a($data->name, ['/company/view', 'id' => $data->id]);
                }
            ],
            [
                'attribute' => 'city',
                'label' => 'Standort',
                'headerOptions'  => ['class' => 'second-col', 'data-hide' => 'mediaXXsmall,phone'],
                'contentOptions' => ['class' => 'second-col'],
                'value' => function ($data){
                    if($data->city){
                        return $data->city;
                    }
                    return '';
                }
            ],
            [
                'attribute' => 'sector',
                'headerOptions'  => ['class' => 'third-col', 'data-hide' => 'mediaXsmall,phone'],
                'contentOptions' => ['class' => 'third-col'],
                'value'     => function ($data) {
                    if ($data->sector) {
                        return $GLOBALS['sectors'][$data->sector];
                    }
                    return '';
                },
            ],
            [
                'attribute' => 'employeeAmount',
                'label' => 'Anzahl Mitarbeiter',
                'headerOptions'  => ['class' => 'fourth-col', 'data-hide' => 'mediaXsmall,phone'],
                'contentOptions' => ['class' => 'fourth-col'],

                'value'     => function ($data) {
                    if ($data->employeeAmount) {
                        return $GLOBALS['employees'][$data->employeeAmount];
                    }
                    return '';
                }
            ],

            [
                'class'    => 'yii\grid\ActionColumn',
                'template' => '{view}',
                'headerOptions'  => ['class' => 'fifth-col', 'data-hide' => 'mediaXXsmall,phone'],
                'contentOptions' => ['class' => 'fifth-col'],
            ],
            [

                'class' => 'yii\grid\Column',
                'headerOptions' => ['data-toggle' => 'true', 'class' => 'sixth-col'],
                'contentOptions' => ['data-title' => 'data-toggle', 'class' => 'sixth-col']

            ],
        ],
    ]); ?>

</div>
