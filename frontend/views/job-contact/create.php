<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\JobContacts */

$this->title = Yii::t('app', 'Create Job Contacts');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Job Contacts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="job-contacts-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
