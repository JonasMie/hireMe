<?php

use yii\helpers\Html;
use frontend\controllers\AnalyticsController;

?>

<div class="btnDetail">
<h4>Button auf Seite:</h4> 
<?= $model->site ?><br>Key: <?= $model->key ?>
<h4>Views:</h4>
<?= $model->viewCount ?>
<h4>Clicks:</h4>
<?= $model->clickCount?>
<h4>Interest Rate:</h4>
<?= $model->viewCount/$model->clickCount*100 ?> %
<h4>Conversion Rate:</h4>
<?= AnalyticsController::getConversionRateForBtn($model->id) ?> %
</div>