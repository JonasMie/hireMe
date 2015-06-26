<?php

use yii\helpers\Html;
use yii\bootstrap\Tabs;
use frontend\controllers\JobController;
use frontend\assets\DataHandlingAsset;

DataHandlingAsset::register($this);
/* @var $this yii\web\View */
/* @var $searchModel frontend\models\JobSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Jetzt bewerben - mit hireMe';
?>

<?
$key = Yii::$app->request->get("key");
Yii::trace("Key: ".$key);
?>

<div class="col-xs-12">
Logo
<p class="hidden" id="user"><?= $userID ?></p>
</div>

<?
$key = Yii::$app->request->get("key");
Yii::trace("Key: ".$key);

?>


<?php

echo Tabs::widget([
    'items' => [
        [
            'label' => 'Bewerben',
            'content' =>  Yii::$app->controller->createAndEdit(Yii::$app->request->get("key"),$userID),//enderPartial("buttonAddData"),
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
					Als Favorit speichern
				</div>
			',
        ],
    ],
]);

?>