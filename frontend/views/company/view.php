<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Company */
/* @var $jobDP yii\data\ActiveDataProvider */


include Yii::getAlias('@helper/companySignup.php');;

$this->title = $model->name;
?>
<div class="company-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="company-name">
        <?= $model->name ?>
    </div>

    <div class="company-street">
        <?= $model->street ?>
    </div>

    <div class="company-house-number">
        <?= $model->houseno ?>
    </div>

    <div class="company-zip">
        <?= $model->zip ?>
    </div>

    <div class="companycty">
        <?= $model->city ?>
    </div>

    <di class="company-sector"v>
        <p>Branche: <?= $sectorList[$model->sector] ?></p>
    </div>

    <div class="company-employee-amaount">
        <p> Anzahl der Beschäftigten: <?= $employeeAmount[$model->employeeAmount] ?></p>
    </div>
</div>

<div>
    <?=
    \yii\grid\GridView::widget([
        'dataProvider' => $jobDP,
        'columns'      => [
            [
                'attribute' => 'title',
                'format' => 'raw',
                'value' => function ($data){
                    return Html::a($data->title, ['/job/view', 'id'=> $data->id]);
                }
            ],
            [
                'attribute' => 'job_begin',
                'format' => 'date'
            ],
            [
                'attribute' => 'job_end',
                'format' => 'date'
            ],
            [
                'attribute' => 'city'
            ],
            // TODO: include is only available in global scope.. got no idea how to access it in method call
//            [
//                'attribute' => 'sector',
//                'value' => function($data){
//                    return $sectorList[$data->sector];
//                }
//            ]
        ]
    ])
    ?>
</div>