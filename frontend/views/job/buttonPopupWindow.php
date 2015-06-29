<?php

use yii\helpers\Html;
use yii\bootstrap\Tabs;
use frontend\controllers\JobController;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\JobSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Jetzt bewerben - mit hireMe';
?>

<div class="col-sm-12 logo">
<img id="navbar-logo" src="/images/hireMe-Web.png"/>
<span class="hidden" id="user"><?= $userID ?></span>
<span class="hidden" id="key"><?= $key ?></span>
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