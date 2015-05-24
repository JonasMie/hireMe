<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
<<<<<<< HEAD
/* @var $model frontend\models\Job */

$this->title = 'Create Job';
$this->params['breadcrumbs'][] = ['label' => 'Jobs', 'url' => ['index']];
=======
/* @var $model app\models\Job */

$this->title = Yii::t('app', 'Create Job');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Jobs'), 'url' => ['index']];
>>>>>>> Complete generated files (views, models & controllers) and minor changes
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="job-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
