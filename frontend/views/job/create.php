<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\JobAd */

$this->title = Yii::t('app', 'Create Job Ad');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Job Ads'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="job-ad-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
