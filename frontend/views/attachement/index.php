<?php
/* @var $this yii\web\View */
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = 'Anlagen';
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
<div class="row">
	<div class="col-sm-12">
		<h1><?= Html::encode($this->title) ?></h1>
	</div>
</div>

<div class="row">
	<div class="col-sm-8">
		<h2>Verfügbare Anlagen</h2>

		<?= GridView::widget([
				'dataProvider' => $provider,
				'tableOptions' => ['class' => 'hireMeTable footable toggle-arrow', 'id' => 'attachmentTable'],
				'id' => "uploadedGrid",
				'columns'      => [
					[
						'label'  => 'Titel',
						'format' => 'raw',
						'value'  => 'title',
						'headerOptions'  => ['class' => 'first-col'],
						'contentOptions' => ['class' => 'first-col'],
					], 
					[
						'label'  => '',
						'format' => 'raw',
						'value'  => function ($data) {
							return  Html::a("<span class='glyphicon glyphicon-eye-open'></span>&nbsp;Anschauen","/attachement/show-file?id=".$data['id'],['target' => '_blank',"class" => "offset"]);
						},
						'headerOptions'  => ['class' => 'second-col','data-hide' => 'mediaXsmall,mediaXXsmall,phone'],
						'contentOptions' => ['class' => 'second-col'],
					],
					[
						'label'  => '',
						'format' => 'raw',
						'value'  => function ($data) {
							return  Html::a("<span class='glyphicon glyphicon-pencil'></span>&nbsp;Bearbeiten","/attachement/update?id=".$data['id'],["class" => "offset"]);
						},
						'headerOptions'  => ['class' => 'third-col','data-hide' => 'mediaSmall,mediaXsmall,mediaXXsmall,phone'],
						'contentOptions' => ['class' => 'third-col'],
					],
					[
						'label'  => '',
						'format' => 'raw',
						'value'  => function ($data) {
							return  Html::a("<span class='glyphicon glyphicon-remove'></span>&nbsp;Löschen","/attachement/delete-file?id=".$data['id'],["class" => "offset"]);
						},
						'headerOptions'  => ['class' => 'fourth-col','data-hide' => 'mediaSmall,mediaXsmall,mediaXXsmall,phone'],
						'contentOptions' => ['class' => 'fourth-col'],
					],
					[
						'class'          => 'yii\grid\Column',
						'headerOptions'  => ['data-toggle' => 'true'],
						'contentOptions' => ['data-title' => 'data-toggle', 'class' => 'fifth-col']
					],
				],
			]);
		?>
	</div>
	
	<div class="col-sm-4">
	<h2>Anhang hochladen</h2>
		<div id="data">
			<?= Yii::$app->controller->renderPartial("uploadSection", ['model' =>$model, 'provider' => $provider]) ?>
		</div>
	</div>
	
</div>