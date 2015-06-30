<?php

use yii\helpers\Html;
use frontend\controllers\AnalyticsController;
use yii\widgets\ListView;
use frontend\models\Analytics;
?>

<div class="jobItem col-sm-12">

	<h2>
	<?= Html::a($model['title'],"/job/view?id=".$model['id']); ?>
	</h2>
	<div class="row">
				<div class="col-xs-2 info totalApplicants">
					<div class="tile-left"><?= Html::encode(count(Analytics::getAppliesForJob($model['id']))) ?></div>
					<div class="tile-right">Bewerbungen</div>
				</div>
				<div class="col-xs-2 info newApplicants">
					<div class="tile-left"><?= Html::encode(Analytics::getUnreadApplicationsForJob($model['id'])) ?></div>
					<div class="tile-right">neue Bewerbungen</div>
				</div>
				<div class="col-xs-2 info analytics">
					<?= Html::a("<div class='tile-left'><span class='glyphicon glyphicon-signal'></span></div>
					<div class='tile-right'>Analytics</div>","/analytics/detail?id=".$model['id']) ?>
				</div>
				<div class="col-xs-2 info jobView">
					<?= Html::a("<div class='tile-left'><span class='glyphicon glyphicon-eye-open'></span></div>
					<div class='tile-right'>Ansehen</div>","/job/view?id=".$model['id']); ?>
				</div>
				<div class="col-xs-2 info jobEdit">
					<?= Html::a("<div class='tile-left'><span class='glyphicon glyphicon-pencil'></span></div>
					<div class='tile-right'>Bearbeiten</div>","/job/update-job?id=".$model['id']); ?>
				</div>
		
	</div>
	<div class="row">
		<div class="col-sm-12">
		 <?= 
			ListView::widget([
				'dataProvider' => $subProvider,
				'itemView' =>function($data) use ($model){
					return $this->render('jobSubItem',[
						'model' => $data,
						'job' => $model['id'],
					]); 
				}
				]);

			?>
		</div>
	</div>
</div>