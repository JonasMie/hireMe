<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
<<<<<<< HEAD
/* @var $searchModel frontend\models\JobSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Jobs';
=======
/* @var $searchModel app\models\JobSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Jobs');
>>>>>>> Complete generated files (views, models & controllers) and minor changes
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="job-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
<<<<<<< HEAD
        <?= Html::a('Create Job', ['create'], ['class' => 'btn btn-success']) ?>
=======
        <?= Html::a(Yii::t('app', 'Create Job'), ['create'], ['class' => 'btn btn-success']) ?>
>>>>>>> Complete generated files (views, models & controllers) and minor changes
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'description',
            'job_begin',
            'job_end',
            'zip',
            // 'sector',
            // 'company_id',
            // 'active',
            // 'created_at',
            // 'updated_at',
<<<<<<< HEAD
            // 'title',
=======
            // 'type',
            // 'city',
            // 'time:datetime',
            // 'allocated',
>>>>>>> Complete generated files (views, models & controllers) and minor changes

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
