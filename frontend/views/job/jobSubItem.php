<?php

use yii\helpers\Html;
use frontend\controllers\AnalyticsController;
use common\models\User;
use frontend\models\Application;

?>

<div class="jobSubItem">
    <span class="info profilePicture"><?= Html::a(User::findOne($model["id"])->getProfilePicture(true),"/application/view?id=".Application::find()->where(['job_id' => $job, "user_id" => $model["id"]])->one()->id,["title" => User::findOne($model["id"])->fullName])?></span>
	
</div>
