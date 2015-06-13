<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\FavouritesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Favoriten');
?>
<div class="favourites-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel'  => $searchModel,
        'columns'      => [
            ['class' => 'yii\grid\SerialColumn'],
            ['class' => 'yii\grid\CheckboxColumn'],
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
                'class' => 'yii\grid\ActionColumn',
                'template' => '{delete}'
            ],
        ],
    ]); ?>


    <p>
        <?= Html::a(Yii::t('app', 'Nach Jobs suchen'), ['/job'], ['class' => 'btn btn-success']) ?>
    </p>

</div>
