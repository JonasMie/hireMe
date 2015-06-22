<?php

use yii\helpers\Html;
use frontend\controllers\AnalyticsController;
use common\models\User;

?>

<div class="jobSubItem">
    <?= User::findOne($model["id"])->getProfilePicture(true) ?>
</div>
