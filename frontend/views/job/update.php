<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Job */

$this->title = 'Stellenanzeige "' .$model->title .'" bearbeiten';
?>
<div class="job-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('updateForm', [
        'model' => $model,
    ]) ?>

</div>
