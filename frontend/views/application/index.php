<?php

use yii\helpers\Html;
use yii\grid\GridView;
use frontend\models\Application;
use frontend\controllers\ApplicationController;
use frontend\controllers\UserController;
use frontend\models\Job;
use yii\widgets\ListView;
use common\models\User;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\ApplicationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>
<div class="row">
	<div class="col-sm-8 col-sm-offset-1">
		<h1><?= Html::encode($this->title) ?></h1>
	</div>
	<div class="col-sm-2 searchBtn">
		<?= Html::a(Yii::t('app', 'Stellenanzeigen suchen'), ['/job'], ['class' => 'btn btn-success ripple']) ?>
	</div>
</div>
<div class="row">
	<div class="col-sm-10 col-sm-offset-1">
		<div class="application-index">

			 <? if (Yii::$app->user->identity->isRecruiter()): ?>
			   
				 <h1><?= Html::encode($title) ?></h1>

		  <?= GridView::widget([
				'dataProvider' => $provider,
				'tableOptions' => ['class' => 'hireMeTable footable toggle-arrow', 'id' => 'inboxTable'],
				'columns'      => [
				[
						'attribute' => 'fullName',
						'label' => 'Name',
						'format' => 'raw',
						'value'  => function ($data) {
							return User::findOne($data["userID"])->getProfilePicture(true)."".Html::a($data['fullName'],'/user?un='.$data['userName']);
						}
				], 
				 'title:text:Stelle',
				 [
						'attribute' => 'created_at',
						'label' => 'Beworben am',
						'format' => 'raw',
						'value'  => function ($data) {
							return Html::encode($data['created_at']);
						}
				], 
				[
						'label'  => '',
						'format' => 'raw',
						'value'  => function ($data) {
							return Html::a(["Ansehen"],['/application/view?id='.$data['id']]);
						}
				],    
				],

			]); ?>  


			  <? else:?>

			 <h2><?= Html::encode("Gespeicherte Bewerbungen") ?></h2>

			 <?= GridView::widget([
				'dataProvider' => $savedProvider,
				'tableOptions' => ['class' => 'hireMeTable footable toggle-arrow', 'id' => 'inboxTable'],
				'columns'      => [
				 [
						'label'  => 'Stellenanzeige',
						'format' => 'raw',
						'value'  => function ($data) {
							return Html::a(Job::getTitle($data->job_id),"/application/add-data?id=".$data->id);
						},
						'headerOptions'  => ['class' => 'first-col'],
						'contentOptions' => ['class' => 'first-col']
					],

				[
						'label'  => 'Erstellt',
						'format' => 'raw',
						'value'  => function ($data) {
							return Html::encode($data->created_at);
						},
						'headerOptions'  => ['class' => 'second-col'],
						'contentOptions' => ['class' => 'second-col']
				],    
				[
						'label'  => '',
						'format' => 'raw',
						'value'  => function ($data) {
							return Html::a("<span class='glyphicon glyphicon-pencil'></span>",'/application/add-data?id='.$data->id, ['class' => 'btn btn-success ripple']) . Html::a("Bearbeiten","/application/add-data?id=".$data->id, ['class' => 'btn btn-primary ripple']);
						},
						'headerOptions'  => ['class' => 'third-col'],
						'contentOptions' => ['class' => 'third-col']
				],    
				],

			]); ?>  
			 <h2><?= Html::encode("Gesendete Bewerbungen:") ?></h2>

			<?= GridView::widget([
				'dataProvider' => $sentProvider,
				'tableOptions' => ['class' => 'hireMeTable footable toggle-arrow', 'id' => 'inboxTable'],
				'columns'      => [
				 [
						'label'  => 'Stellenanzeige',
						'format' => 'raw',
						'value'  => function ($data) {
							return Job::getTitle($data->job_id);
						},
						'headerOptions'  => ['class' => 'first-col'],
						'contentOptions' => ['class' => 'first-col']
					],

				[
						'label'  => 'Erstellt',
						'format' => 'raw',
						'value'  => function ($data) {
							return Html::encode($data->created_at);
						},
						'headerOptions'  => ['class' => 'second-col'],
						'contentOptions' => ['class' => 'second-col']
				],    
				  [
						'label'  => 'Status',
						'format' => 'raw',
						'value'  => function ($data) {
							return Html::encode($data->state);
						},
						'headerOptions'  => ['class' => 'third-col'],
						'contentOptions' => ['class' => 'third-col']
				],    
				[
						'label'  => '',
						'format' => 'raw',
						'value'  => function ($data) {
							return Html::a("Ansehen",'/application/view?id='.$data->id);
						}
				],    
				],

			]); ?>
			
			<? endif; ?>

		</div>
	</div>
</div>