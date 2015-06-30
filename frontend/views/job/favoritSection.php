<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use frontend\models\ApplicationData;
use yii\widgets\ActiveForm;

?>

<div class="col-sm-12">
	<h1>In Favoriten speichern</h1>
	<p>Du kannst diese Stellenanzeige auch als Favorit speichern und dich später auf hireMe auf diese Stelle bewerben.</p>
	<div class="saveFav">
		<?= Html::button('<span class="glyphicon glyphicon-star"></span>&nbsp;&nbsp;Als Favorit speichern', ['class' => 'btn btn-success','id' => "addFavourite",'onclick' => 'addFav()']) ?>
	</div>
</div>