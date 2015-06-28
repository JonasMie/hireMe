<?php

use yii\helpers\Html;
use yii\bootstrap\Tabs;
use frontend\controllers\JobController;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\JobSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Jetzt bewerben - mit hireMe';
?>

<div class="col-xs-12">
Logo
<p class="hidden" id="user"><?= $userID ?></p>
<p class="hidden" id="key"><?= $key ?></p>
</div>

<?=
    Tabs::widget([
    'items' => [
        [
            'label' => 'Bewerben',
            'content' =>  Yii::$app->controller->createApplyForm($key,$userID),
            'active' => true
        ],
        [
            'label' => 'Favoriten',
            'content' => '
				<div class="col-xs-12"><h1>Stellenanzeige Titel</h1></div>
				<div class="col-xs-12">
					<h2>Als Favorit speichern</h2>
					<p>Du kannst diese Stellenanzeige auch als Favorit speichern und dich sp&auml;ter auf hireMe auf diese Stelle bewerben.</p>
				</div>
				<div class="col-xs-12">
					<button id="addFavourite" onclick="addFav()">Als Favorit speichern</button>
				</div>
			',
        ],
    ],
]);

?>