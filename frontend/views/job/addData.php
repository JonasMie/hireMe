<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use frontend\models\ApplicationData;
use yii\widgets\ActiveForm;
use frontend\assets\ApplyFormAsset;
ApplyFormAsset::register($this);

/* @var $this yii\web\View */
/* @var $model frontend\models\Application */

?>
<p class="hidden" id="controller"><?= $controller ?></p>
<p class="hidden" id="jobID"><?= $job->id ?></p>

<h2>Neue Bewerbung auf die Stellenanzeige: <?= $job->title ?></h2>
    
    <h3>Persönliches Anschreiben:</h3>

    <?= Html::textarea("Anschreiben","",['id' => 'coverText','rows' => 10,'cols' => 100]) ?>    
    <div id="files">
    <?=     
    Yii::$app->controller->renderPartial("fileSection",[
        'provider' => $provider,
        ],false,false);
    ?>
        <?= Html::button('<span class="glyphicon glyphicon-floppy-disk"></span>&nbsp;&nbsp;Bewerbung speichern', ['class' => 'btn btn-success', 'name' => 'create-button','id' => "saveApplication"]) ?>
    </div>

    <?= Html::button("Bewerbung senden",['id' => "sendApp"]) ?>



