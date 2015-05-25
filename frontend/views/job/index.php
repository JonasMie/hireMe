<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
<<<<<<< HEAD
<<<<<<< HEAD
/* @var $searchModel frontend\models\JobSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Jobs';
=======
=======
>>>>>>> bc255c11865ac6559952248f9b47f4fe9381674c
/* @var $searchModel app\models\JobSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Jobs');
<<<<<<< HEAD
>>>>>>> Complete generated files (views, models & controllers) and minor changes
=======
>>>>>>> bc255c11865ac6559952248f9b47f4fe9381674c
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="job-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
<<<<<<< HEAD
<<<<<<< HEAD
        <?= Html::a('Create Job', ['create'], ['class' => 'btn btn-success']) ?>
=======
        <?= Html::a(Yii::t('app', 'Create Job'), ['create'], ['class' => 'btn btn-success']) ?>
>>>>>>> Complete generated files (views, models & controllers) and minor changes
=======
        <?= Html::a(Yii::t('app', 'Create Job'), ['create'], ['class' => 'btn btn-success']) ?>
>>>>>>> bc255c11865ac6559952248f9b47f4fe9381674c
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
<<<<<<< HEAD
            // 'title',
=======
=======
>>>>>>> bc255c11865ac6559952248f9b47f4fe9381674c
            // 'type',
            // 'city',
            // 'time:datetime',
            // 'allocated',
<<<<<<< HEAD
>>>>>>> Complete generated files (views, models & controllers) and minor changes
=======
>>>>>>> bc255c11865ac6559952248f9b47f4fe9381674c

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
