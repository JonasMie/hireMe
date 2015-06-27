<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use frontend\models\ApplicationData;
use yii\widgets\ActiveForm;

?>
<!-- Initializing Foo Tables -->

 <h3>Anhänge auswählen:</h3>

         <?= GridView::widget([
                'dataProvider' => $provider,
                'tableOptions' => ['class' => 'hireMeTable footable toggle-arrow', 'id' => 'applicationTable'],
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
                                return  Html::button("Mitschicken",['id' => 'addAttachement'.$data['id'],'onclick'=>'js:addData('.$data['id'].');']);
                    }    
                ], 
               [
                    'label'  => 'Anschauen',
                    'format' => 'raw',
                    'value'  => function ($data) {
                        return  Html::a("Anschauen","/application/show-file?id=".$data['id'],['target' => '_blank']);
                    }
                ], 
                [
                    'label'  => '',
                    'format' => 'raw',
                    'value'  => function ($data) {
                        return  Html::label("",null,['id' => "show_".$data['id']]);
                    }
                ], 
                    ],

            ]); ?>  


