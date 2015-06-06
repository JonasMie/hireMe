<?php

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\widgets\ListView;
use yii\grid\GridView;
use frontend\models\analytics;
use frontend\models\MyJobsGridView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Job */

$this->title = "Stellenanzeigen von " .$companyName;
$this->params['breadcrumbs'][] = ['label' => 'Jobs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="_myjobs">

    <h1><?= Html::encode($this->title) ?></h1>
    <a href="http://frontend/job/create"><button>Neue Stellenanzeige</button></a>
    <button>
    <?= Html::a("Nach Datum","/job/my-jobs?companyId=".$id."&sort=+job_begin");?>   
    </button>
    <button>
    <?= Html::a("Nach Bewerber","/job/my-jobs?companyId=".$id."&sort=+applier");?>   
    </button>    <br>
    <p>


        <?= GridView::widget([
        'dataProvider' => $provider,
        'columns'      => [
            [
                'label'  => 'Titel',
                'format' => 'raw',
                'value'  => function ($data) {
                    return \yii\helpers\Html::encode($data->title);
                }
            ],
            [

                'label'  => 'Datum',
                'format' => 'raw',
                'value'  => function ($data) {
                    return \yii\helpers\Html::encode($data->job_begin);
                }
            ],
            [

                'label'  => 'Bewerber',
                'format' => 'raw',
                'value'  => function ($data) {
                    return \yii\helpers\Html::encode(count(Analytics::getAppliesForJob($data->id)))." - ".\yii\helpers\Html::a("Analytics","/analytics/detail?id=".$data->id);
                }
            ],
        ],
    ]); ?>
    
    </p>

</div>
