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
                'label'  => 'Titel',
                'format' => 'raw',
                'value'  => 'title'
            ], 
            [
                'label'  => 'Mitschicken',
                'format' => 'raw',
                'value'  => function ($data) {
                    return  Html::a(Html::button("Mitschicken"),"/application/data-handler?id=".$data['id']."&appID=".$data['application_id']."&direction=1");
                }
            ], 
            [
                'label'  => 'Anschauen',
                'format' => 'raw',
                'value'  => function ($data) {
                    return  Html::a("Anschauen","/application/show-file?id=".$data['id'],['target' => '_blank']);
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



