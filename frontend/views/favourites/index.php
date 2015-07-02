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
		<div class="col-sm-12">
			<h1><?= Html::encode($this->title) ?></h1>
		</div>
		<div class="col-sm-12 searchBtn">
			<?= Html::a(Yii::t('app', 'Stellenanzeigen suchen'), ['/job'], ['class' => 'btn btn-success ripple']) ?>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<?= GridView::widget([
				'dataProvider' => $dataProvider,
		//        'filterModel'  => $searchModel,
				'tableOptions' => ['class' => 'hireMeTable footable toggle-arrow', 'id' => 'favouritesTable'],
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
							return Html::a($data->job->title, ['/job/view','id' => $data->job->id]);
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
						'headerOptions'  => ['class' => 'third-col'],
						'contentOptions' => ['class' => 'third-col']
					],
					[
						'attribute'     => 'jobBegin',
						'format'        => 'date',
						'label'         => 'Verfügbar ab',
						'value' => function($data){
							return $data->job->job_begin;
						},
						'headerOptions'  => ['class' => 'fourth-col','data-hide' => 'mediaXsmall,phone'],
						'contentOptions' => ['class' => 'fourth-col']
					],
					[
						'class' => 'yii\grid\ActionColumn',
						'template' => '{delete}',
						'headerOptions'  => ['class' => 'fourth-col','data-hide' => 'mediaXsmall,phone'],
						'contentOptions' => ['class' => 'fourth-col']
					],
					[
						'class'          => 'yii\grid\Column',
						'headerOptions'  => ['data-toggle' => 'true'],
						'contentOptions' => ['data-title' => 'data-toggle', 'class' => 'fifth-col']
					],
				],
			]); ?>
            <? if ($dataProvider->count > 0): ?>
			<div class="dropdown" id="bulkActions" data-index="0">
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
            <? endif ?>
		</div>
	</div>
</div>
