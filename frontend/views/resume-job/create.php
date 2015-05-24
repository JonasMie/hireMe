<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\ResumeJob */

$this->title = Yii::t('app', 'Create Resume Job');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Resume Jobs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="resume-job-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
