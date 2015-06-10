<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\ResumeJob */

$this->title = Yii::t('app', 'Arbeitsstelle hinzufügen');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Lebenslauf'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="resume-job-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_jobResumeForm', [
        'model' => $model,
    ]) ?>

</div>
