<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use frontend\models\ApplicationData;
use yii\widgets\ActiveForm;
use frontend\assets\DataHandlingAsset;

DataHandlingAsset::register($this);


/* @var $this yii\web\View */
/* @var $model frontend\models\Application */

?>
<h2>Neue Bewerbung auf die Stellenanzeige: <?= $job->title ?></h2>

    <h3>Persönliches Anschreiben:</h3>

    <?php $form = ActiveForm::begin(['id' => 'form-createCover']); ?>
    <?= $form->field($model, 'text')->textarea() ?>
    <?= Html::submitButton('Erstellen', ['class' => 'btn btn-primary', 'name' => 'create-button']) ?>
    <?php ActiveForm::end(); ?>
   
    <div id="files">
    <?=     

    Yii::$app->controller->renderPartial("fileSection",[
        'provider' => $provider,
        'sentProvider' => $sentProvider,
        'appId' => $appId,
        ]);
    ?>

    </div>
    <br>
    <br>

    <?= Html::a(Html::button("Bewerbung senden"),'/job/send?id='.$appId,['target' => '_blank']) ?>



