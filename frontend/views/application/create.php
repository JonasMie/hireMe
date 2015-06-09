<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\Application */

$this->title = Yii::t('app', 'Create Application');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Applications'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="application-create">

    <h2>Neue Bewerbung auf die Stellenanzeige: <?= $job->title ?></h2>
    <h3>Deine Qualifikationen:</h3>
    <div id="data">
    <?= Yii::$app->controller->renderPartial("uploadSection", ['model' =>$model, 'provider' => $provider]) ?>
	</div>

	<?= Html::a(Html::button("Bewerbung senden")) ?>

</div>
