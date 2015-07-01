<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\grid\GridView;
use frontend\controllers\ApplicationController;

?>

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

	<?= $form->field($model, 'file')->fileInput(['multiple' => false])->label('') ?>

	<?= $form->field($model, 'title') ?>

	<div class="form-group">
		<?= Html::submitButton("<span class='glyphicon glyphicon-upload'></span>&nbsp;&nbsp;Hochladen",['class' => 'btn btn-success upload']) ?>
	</div>

<?php ActiveForm::end(); ?>
