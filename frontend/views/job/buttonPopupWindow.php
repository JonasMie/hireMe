<?php

use yii\helpers\Html;
use yii\bootstrap\Tabs;
/* @var $this yii\web\View */
/* @var $searchModel frontend\models\JobSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Jetzt bewerben - mit hireMe';
?>

<div class="col-xs-12">
Logo
</div>

<?php
echo Tabs::widget([
    'items' => [
        [
            'label' => 'Bewerben',
            'content' => ''.'
				<div class="col-xs-12"><h1>Stellenanzeige Titel</h1></div>
				<div class="col-xs-12">
					<h2>Anschreiben</h2>
					<textarea rows="4" cols="50">Anschreiben</textarea>
				</div>
				<div class="col-xs-12">
					<h2>Anlagen ausw&auml;hlen<h2>
					<p>Anlagen</p>
				</div>
				<div class="col-xs-12">
					Jetzt bewerben
				</div>
			'.'',
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