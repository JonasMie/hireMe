<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\FavouritesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Favoriten');
\frontend\assets\BulkAction::register($this);
?>
<div class="favourites-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//        'filterModel'  => $searchModel,
        'options' => [
            'data-type' => 'favourites',
            'class' => 'grid-view'
        ],
        'columns'      => [
            [
                'class' => 'yii\grid\CheckboxColumn',
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
                    return Html::a($data->job->description, ['/job/view','id' => $data->job->id]);
                },
            ],
            [
                'attribute' => 'company',
                'label' => 'Unternehmen',
                'format' => 'raw',
                'value'     => function ($data) {
                    return Html::a($data->job->company->name, ['/company/view' ,'id'=> $data->job->company->id]);
                },
            ],
            [
                'attribute'     => 'jobBegin',
                'format'        => 'date',
                'label'         => 'Verfügbar ab',
                'value' => function($data){
                    return Yii::$app->formatter->asDate($data->job->job_begin, "php: d.m.Y");
                },
                'headerOptions' => ['data-hide' => 'xsmall,phone'],

            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{delete}'
            ],
        ],
        'showFooter' => true,
    ]); ?>


    <p>
        <?= Html::a(Yii::t('app', 'Nach Jobs suchen'), ['/job'], ['class' => 'btn btn-success']) ?>
    </p>

</div>
