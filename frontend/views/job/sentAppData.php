<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use frontend\models\ApplicationData;
use yii\widgets\ActiveForm;
use frontend\assets\DataHandlingAsset;

DataHandlingAsset::register($this);

?>

<?= GridView::widget([
        'dataProvider' => $sentProvider,
        'tableOptions' => ['class' => 'hireMeTable footable toggle-arrow', 'id' => 'inboxTable'],
        'id' => "uploadedGrid",
        'columns'      => [
            [
                'label'  => 'Titel',
                'format' => 'raw',
                'value'  => 'title'
            ], 
            [
                'label'  => 'Einbehalten',
                'format' => 'raw',
                'value'  => function ($data) use ($appId) {                 ;
                            return  Html::button("Einbehalten",['id' => 'addAttachement']);//,"/job/data-handler?id=".$data['id']."&appID=".$appId."&direction=1");
                }
            ], 
        ],
    ]); ?> 