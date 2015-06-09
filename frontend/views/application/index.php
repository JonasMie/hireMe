<?php

use yii\helpers\Html;
use yii\grid\GridView;
use frontend\models\Application;
use frontend\controllers\ApplicationController;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\ApplicationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Applications');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="application-index">

     <? if (Yii::$app->user->identity->isRecruiter()): ?>

         <h1><?= Html::encode("Eingegangene Bewerbungen") ?></h1>

  <?= GridView::widget([
        'dataProvider' => $provider,
        'columns'      => [
         [
                'label'  => 'Stellenanzeige',
                'format' => 'raw',
                'value'  => function ($data) {
                    return ApplicationController::getJobTitle($data->job_id);
                }
            ],    
        [
                'label'  => 'Bewerber',
                'format' => 'raw',
                'value'  => function ($data) {
                    return ApplicationController::getApplierName($data->user_id);
                }
            ],    
        ],
    ]); ?>  

      <? endif; ?>

</div>
