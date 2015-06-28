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
            'content' => Yii::$app->controller->createFavoritSection($key,$userID),
            'active' => false
        ],
    ],
]);

?>