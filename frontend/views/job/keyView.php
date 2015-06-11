<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use frontend\assets\CreateJobAsset;
use yii\helpers\Url;
use frontend\controllers\JobController;
?>

	<script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
		<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
  		<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>


<?= Html::encode("Direkter Code für Button: ".$key) ?>
<br><br>
<?= Html::textArea("",$text,['rows'=>6, 'cols'=>60]); ?>
