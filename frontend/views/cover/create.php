<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\Cover */

$this->title = Yii::t('app', 'Create Cover');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Covers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cover-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
