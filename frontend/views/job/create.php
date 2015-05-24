<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
<<<<<<< HEAD
<<<<<<< HEAD
/* @var $model frontend\models\Job */

$this->title = 'Create Job';
$this->params['breadcrumbs'][] = ['label' => 'Jobs', 'url' => ['index']];
=======
=======
>>>>>>> bc255c11865ac6559952248f9b47f4fe9381674c
/* @var $model app\models\Job */

$this->title = Yii::t('app', 'Create Job');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Jobs'), 'url' => ['index']];
<<<<<<< HEAD
>>>>>>> Complete generated files (views, models & controllers) and minor changes
=======
>>>>>>> bc255c11865ac6559952248f9b47f4fe9381674c
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="job-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
