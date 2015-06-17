<?php

use yii\helpers\Html;
use frontend\assets\CheckAsset;
use yii\grid\GridView;

CheckAsset::register($this);

/* @var $this yii\web\View */
/* @var $model frontend\models\Application */

?>
<div class="application-create">

    <h2>Neue Bewerbung auf die Stellenanzeige: <?= $job->title ?></h2>
    <h3>Deine Qualifikationen:</h3>
    <div id="data">
    <?= Yii::$app->controller->renderPartial("uploadSection", ['model' =>$model, 'provider' => $provider]) ?>
	</div>
	<h3>Anhänge:</h3>
	<?= GridView::widget([
        'dataProvider' => $appDataProvider,
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
                'value'  => function ($data) {
                    return  Html::a(Html::button("Einbehalten"),"/application/data-handler?id=".$data['id']."&appID=".$data["application_id"]."&direction=0");
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

	<?= Html::a(Html::button("Bewerbung senden"),'/application/send?id='.$appId) ?>

</div>
