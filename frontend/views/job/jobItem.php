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
	<div class="col-sm-10">
		<div class="row">
			<div class="col-sm-2 col-lg-2 info totalApplicants">
				<span class="top"><?= Html::encode(count(Analytics::getAppliesForJob($model['id']))) ?></span>
				<span class="bottom">Bewerbungen</span></div>
			<div class="col-sm-2 col-lg-2 info newApplicants">
				<span class="top"><?= Html::encode(Analytics::getUnreadApplicationsForJob($model['id'])) ?></span>
				<span class="bottom">neue Bewerbungen</span>
			</div>
			<div class="col-sm-2 col-lg-2 info analytics">
				<?= Html::a("<span class='top'><span class='glyphicon glyphicon-signal'></span></span>
				<span class='bottom'>Analytics</span>","/analytics/detail?id=".$model['id']) ?>
			</div>
			<div class="col-sm-2 col-lg-2 info jobView">
				<?= Html::a("<span class='top'><span class='glyphicon glyphicon-eye-open'></span></span>
				<span class='bottom'>Ansehen</span>","/job/view?id=".$model['id']); ?>
			</div>
			<div class="col-sm-2 col-lg-2 info jobEdit">
				<?= Html::a("<span class='top'><span class='glyphicon glyphicon-pencil'></span></span>
				<span class='bottom'>Bearbeiten</span>","/job/update-job?id=".$model['id']); ?>
			</div>
		</div>
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