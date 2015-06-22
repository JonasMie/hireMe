<?php

use yii\helpers\Html;
use frontend\controllers\AnalyticsController;
use yii\widgets\ListView;
use frontend\models\Analytics;
?>

<div class="jobItem">

<h2>
<?= $model['title'] ?>
</h2>
<p>
<?= Html::encode("Neue Bewerber: ".Analytics::getUnreadApplicationsForJob($model['id']))." - ".Html::encode("Bewerber: ".count(Analytics::getAppliesForJob($model['id'])))." - ".Html::a("Analytics","/analytics/detail?id=".$model['id'])." - ".Html::a("Ansehen","/job/view?id=".$model['id']); ?>
<br>
 
 <?= 
    ListView::widget([
        'dataProvider' => $subProvider,
        'itemView' =>function($data) {
            return $this->render('jobSubItem',[
                'model' => $data,
            ]); 
        }
        ]);

    ?>
   <br><br>
</div>
