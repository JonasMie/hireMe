<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\grid\GridView;
use frontend\controllers\ApplicationController;

?>

<?= GridView::widget([
        'dataProvider' => $provider,
        'columns'      => [
         [
                'label'  => 'Mitschicken',
                'format' => 'raw',
                'value'  => function ($data) {
                    return \yii\helpers\Html::checkbox("checkbox",false);
                }
            ],
            [
                'label'  => 'Titel',
                'format' => 'raw',
                'value'  => function ($data) {
                    return  ApplicationController::getFileTitle($data->file_id);
                }
            ],        
        ],
    ]); ?>  

 <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

    <?= $form->field($model, 'file')->fileInput(['multiple' => false]) ?>

    <?= $form->field($model, 'title')->input("Titel:") ?>

    <div class="form-group">
        <?= Html::submitButton("Hochladen") ?>
    </div>

    <?php ActiveForm::end(); ?>
<hr>



