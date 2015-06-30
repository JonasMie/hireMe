<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use frontend\models\ApplicationData;
use yii\widgets\ActiveForm;
use frontend\assets\ApplyFormAsset;
ApplyFormAsset::register($this);

/* @var $this yii\web\View */
/* @var $model frontend\models\Application */

?>
<p class="hidden" id="controller"><?= $controller ?></p>
<p class="hidden" id="jobID"><?= $job->id ?></p>

<div class="col-sm-12">

		
	<h1>Bewerbung als: <?= Html::a($job->title,"/job/view?id=".$job->id,['target' => '_blank']); ?></h1>
	
	<div class="sendAlert"><div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Deine Bewerbung wurde verschickt! <?= Html::a("Zur Übersicht auf hireMe","/application",['class' => 'alert-link']); ?></div></div>
	
	<div class="saveAlert"><div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Deine Bewerbung wurde gespeichert. <?= Html::a("Zur Übersicht auf hireMe","/application",['class' => 'alert-link']); ?></div></div>
	
	<h2>Anschreiben</h2>
	<span class="form-group">
		<?= Html::textarea("Anschreiben","",['class'=>'form-control','id' => 'coverText','rows' => 15]) ?>    
	</span>
	
	<div id="files">
	<?=     
	Yii::$app->controller->renderPartial("fileSection",[
		'provider' => $provider,
		],false,false);
	?>
	</div>
	
	<div class="save">
		<?= Html::button('<span class="glyphicon glyphicon-floppy-disk"></span>&nbsp;&nbsp;Bewerbung speichern', ['class' => 'btn btn-success', 'name' => 'create-button','id' => "saveApplication"]) ?>
	</div>
	
	<div class="send">
		<?= Html::button('<span class="glyphicon glyphicon-share"></span>&nbsp;&nbsp;Bewerbung verschicken', ['class' => 'btn btn-success','id' => "sendApp"]) ?>
	</div>
	
</div>