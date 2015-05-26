<?php

use yii\helpers\Html;
use frontend\controllers\AnalyticsController;

?>

<div class="btnDetail">
<h4>Alle Stellenanzeigen::</h4> 
<?= $model->title ?>
<h4>Beschreibung:</h4>
<?= $model->description ?>
<h4>Job Begin:</h4>
<?= $model->job_begin?>
<h4>Job Ende:</h4>
<?= $model->job_end?>
<h4>ZIP:</h4>
<?= $model->zip?>
<h4>Sektor:</h4>
<?= $model->sector?>
<br>
------------
<br>
<button onclick="openDetails(<?= $model->id ?>)">Details</button>

</div>

<script>
function openDetails(jobID) {
	window.location.replace("http://frontend/analytics/detail?id="+jobID);
}
</script>
