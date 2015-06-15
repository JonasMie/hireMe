<?php

use yii\helpers\Html;
use frontend\assets\CheckAsset;

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

	<?= Html::a(Html::button("Bewerbung senden"),'/application/send?id='.$appId) ?>

</div>
