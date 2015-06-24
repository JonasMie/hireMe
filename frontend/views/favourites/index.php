<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\FavouritesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Favoriten');
\frontend\assets\BulkAction::register($this);
?>

<!-- Initializing Foo Tables -->
<? $this->registerJS(
    "$(function () {
        $('.footable').footable({
            breakpoints: {
                /* Somehow Footable misses the screen wdtdh by 31 Pixels */
                mediaXXsmall: 480,
                mediaXsmall: 736,
                mediaSmall: 960

            }
        });
    });");

?>

<div class="favourites-index">

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
			<?= GridView::widget([
				'dataProvider' => $dataProvider,
		//        'filterModel'  => $searchModel,
				'tableOptions' => ['class' => 'hireMeTable footable toggle-arrow', 'id' => 'inboxTable'],
				'options' => [
					'data-type' => 'favourites',
					'class' => 'grid-view'
				],
				'columns'      => [
					[
						'class' => 'yii\grid\CheckboxColumn',
						'headerOptions'  => ['class' => 'first-col'],
						'contentOptions' => ['class' => 'first-col']
					],
					[
						'attribute' => 'jobDescription',
						'label'     => 'Job',
						'format'    => 'raw',
						'value'     => function ($data) {
							return Html::a($data->job->description, ['/job/view','id' => $data->job->id]);
						},
						'headerOptions'  => ['class' => 'second-col'],
						'contentOptions' => ['class' => 'second-col']
					],
					[
						'attribute' => 'company',
						'label' => 'Unternehmen',
						'format' => 'raw',
						'value'     => function ($data) {
							return Html::a($data->job->company->name, ['/company/view' ,'id'=> $data->job->company->id]);
						},
						'headerOptions'  => ['class' => 'third-col','data-hide' => 'xsmall,phone'],
						'contentOptions' => ['class' => 'third-col']
					],
					[
						'attribute'     => 'jobBegin',
						'format'        => 'date',
						'label'         => 'Verfügbar ab',
						'value' => function($data){
							return Yii::$app->formatter->asDate($data->job->job_begin, "php: d.m.Y");
						},
						'headerOptions'  => ['class' => 'fourth-col','data-hide' => 'xsmall,phone'],
						'contentOptions' => ['class' => 'fourth-col']
					],
					[
						'class' => 'yii\grid\ActionColumn',
						'template' => '{delete}'
					],
					[
						'class'          => 'yii\grid\Column',
						'headerOptions'  => ['data-toggle' => 'true'],
						'contentOptions' => ['data-title' => 'data-toggle', 'class' => 'fifth-col']
					],
				],
				/*'showFooter' => true,*/
			]); ?>
			
			<? // TODO: (analog message/index.php) check functionality when correctly arranged ?>

			<div class="dropdown" id="bulkActions">
				<button id="dLabel" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-success">
					Aktion
					<span class="caret"></span>
				</button>
				<ul class="dropdown-menu" aria-labelledby="dLabel">
					<li class="bulkDelete">
						<a href="#" tabindex="-1">Löschen</a>
					</li>
				</ul>
			</div>
		</div>
	</div>
</div>
