<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\File */

$this->title = 'Anlage bearbeiten';

?>
<div class="file-update">

    <h1><?= Html::encode($this->title) ?></h1>
	<h2><?= $model->title ?></h2>
	<div class="row">
		<div class="col-sm-4">
		<?= 
			$this->render('_form', [
				'model' => $model,
				'title' => $model->title,
			])
		?>
		</div>
	</div>
</div>
