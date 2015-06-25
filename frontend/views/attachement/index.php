<?php
/* @var $this yii\web\View */
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>

<h3>Neue Datei hochladen:</h3>
  <div id="data">
    <?= Yii::$app->controller->renderPartial("uploadSection", ['model' =>$model, 'provider' => $provider]) ?>
    </div>
<h3>Anhänge:</h3>

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
                'label'  => 'Anschauen',
                'format' => 'raw',
                'value'  => function ($data) {
                    return  Html::a("Anschauen","/attachement/show-file?id=".$data['id'],['target' => '_blank'])." ".Html::a("Bearbeiten","/attachement/update?id=".$data['id'])."  ".Html::a("Löschen","/attachement/delete-file?id=".$data['id']);
                }
            ], 
        ],
    ]); ?>  