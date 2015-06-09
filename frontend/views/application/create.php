<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\Application */

$this->title = Yii::t('app', 'Create Application');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Applications'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="application-create">

    <h2>Neue Bewerbung auf die Stellenanzeige: <?= $job->title ?></h2>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
