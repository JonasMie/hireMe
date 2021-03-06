<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ApplyBtnSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Apply Btns';
?>
<div class="apply-btn-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Apply Btn', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'job_id',
            'key:ntext',
            'site:ntext',
            'clickCount',
            // 'viewCount',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
