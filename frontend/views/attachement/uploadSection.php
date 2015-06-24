<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\grid\GridView;
use frontend\controllers\ApplicationController;

?>

 <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

    <?= $form->field($model, 'file')->fileInput(['multiple' => false]) ?>

    <?= $form->field($model, 'title')->input("Titel:") ?>

    <div class="form-group">
        <?= Html::submitButton("Hochladen") ?>
    </div>

    <?php ActiveForm::end(); ?>
<hr>


