<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\ResumeJob */

$this->title = Yii::t('app', 'Arbeitsstelle hinzufügen');
?>
<div class="resume-job-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_jobResumeForm', [
        'model' => $model,
    ]) ?>

</div>
