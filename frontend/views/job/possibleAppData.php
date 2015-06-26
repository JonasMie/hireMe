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
                'value'  => function ($data) use ($appId){   
                            $tmpApp = ApplicationData::find()
                            ->where(['file_id' => $data['id'],'application_id'=>$appId])->one();

                            if(count($tmpApp) == 0) {
                            return  Html::button("Mitschicken",['id' => 'addAttachement']);//,"/job/data-handler?id=".$data['id']."&appID=".$appId."&direction=1");
                            }    
                            else {
                            return  Html::encode("Beigefügt");
                                }
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