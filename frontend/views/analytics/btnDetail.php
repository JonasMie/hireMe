<?php

use yii\helpers\Html;
use frontend\controllers\AnalyticsController;
use frontend\models\Analytics;

?>

<div class="btnDetail">
<h4>Button auf Seite:</h4> 
<?= $model->site ?><br>Key: <?= $model->key ?>
<h4>Views:</h4>
<?= $model->viewCount ?>
<h4>Clicks:</h4>
<?= $model->clickCount?>
<h4>Interest Rate:</h4>
<?= $model->clickCount/$model->viewCount*100 ?> %
<h4>Application Rate:</h4>
<?= AnalyticsController::getApplicationRateForBtn($model->id) ?> %
<h4>Interview Rate:</h4>
<?= AnalyticsController::getInterviewRateForBtn($model->id) ?> %
</div>