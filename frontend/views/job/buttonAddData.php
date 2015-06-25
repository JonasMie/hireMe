<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use frontend\models\ApplicationData;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\Application */

?>
<h2>Neue Bewerbung auf die Stellenanzeige: <?= $job->title ?></h2>

    <h3>Persönliches Anschreiben:</h3>

    <?php $form = ActiveForm::begin(['id' => 'form-createCover']); ?>
    <?= $form->field($model, 'text')->textarea() ?>
    <?= Html::submitButton('Erstellen', ['class' => 'btn btn-primary', 'name' => 'create-button']) ?>
    <?php ActiveForm::end(); ?>


    <h3>Anhänge auswählen:</h3>
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
                            return  Html::a(Html::button("Mitschicken"),"/job/data-handler?id=".$data['id']."&appID=".$appId."&direction=1");
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
    <h3>Angehängte:</h3>
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
                    return  Html::a(Html::button("Einbehalten"),"/job/data-handler?id=".$data['id']."&appID=".$appId."&direction=0");
                }
            ], 
        ],
    ]); ?> 
    <br>
    <br>
    <?= Html::a(Html::button("Bewerbung senden"),'/job/send?id='.$appId,['target' => '_blank']) ?>