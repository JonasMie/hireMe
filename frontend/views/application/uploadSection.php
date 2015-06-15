<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\grid\GridView;
use frontend\controllers\ApplicationController;
use frontend\assets\CheckAsset;
CheckAsset::register($this);

?>

<?= GridView::widget([
        'dataProvider' => $provider,
        'tableOptions' => ['class' => 'hireMeTable footable toggle-arrow', 'id' => 'inboxTable'],
        'id' => "uploadedGrid",
        'columns'      => [
        [
            'class'    => 'yii\grid\CheckboxColumn',
        'headerOptions' => ['class'=>'first-col'],
        'contentOptions' => ['class' => 'first-col']

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

<script type="text/javascript">

function userClicks(target_id) {
        alert($.fn.yiiGridView.getSelection(target_id));
}
</script>

 <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

    <?= $form->field($model, 'file')->fileInput(['multiple' => false]) ?>

    <?= $form->field($model, 'title')->input("Titel:") ?>

    <div class="form-group">
        <?= Html::submitButton("Hochladen") ?>
    </div>

    <?php ActiveForm::end(); ?>
<hr>



