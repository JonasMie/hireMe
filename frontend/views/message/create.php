<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\Message */

$this->title = Yii::t('app', 'Nachricht verfassen');
?>
<div class="message-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

