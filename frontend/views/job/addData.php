<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use frontend\models\ApplicationData;
use yii\widgets\ActiveForm;
use frontend\assets\DataHandlingAsset;
use frontend\assets\CreateCoverAsset;

DataHandlingAsset::register($this);
CreateCoverAsset::register($this);


/* @var $this yii\web\View */
/* @var $model frontend\models\Application */

?>
<h2>Neue Bewerbung auf die Stellenanzeige: <?= $job->title ?></h2>

    <h3>Persönliches Anschreiben:</h3>

    <?php $form = ActiveForm::begin(['id' => 'form-createCover']); ?>
    <?= $form->field($model, 'text')->textarea() ?>   
    <div id="files">
    <?=     

    Yii::$app->controller->renderPartial("fileSection",[
        'provider' => $provider,
        'sentProvider' => $sentProvider,
        'appId' => $appId,
        ]);
    ?>

        <div class="col-sm-3 saveBtn">
                    <p class="hidden" id="hiddenApp"><?= $appId ?></p>
     

    </div>
    <br>
    <br>
   <?php ActiveForm::end(); ?>
        <?= Html::button('<span class="glyphicon glyphicon-floppy-disk"></span>&nbsp;&nbsp;sdsd speichern', ['class' => 'btn btn-success', 'name' => 'create-button','id' => "saveCover"]) ?>
                </div>
    <?= Html::a(Html::button("Bewerbung senden"),'/job/send?id='.$appId,['target' => '_blank','id' => "sendIt"]) ?>



