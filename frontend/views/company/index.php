<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\CompanySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Companies');
?>
<div class="company-index">

    <h1><?= Html::encode($this->title) ?></h1>


<? include Yii::getAlias('@helper/companySignup.php');
$GLOBALS['sectors'] = $sectorList;
$GLOBALS['employees'] = $employeeAmount;?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
        'columns'      => [
            [
                'attribute' => 'name',
                'format' => 'raw',
                'value' => function($data){
                    return Html::a($data->name, ['/company/view', 'id' => $data->id]);
                }
            ],
//            'street',
//            'houseno',
//            'zip',
            'city',
            [
                'attribute' => 'sector',
                'value' => function($data) {
                    return $GLOBALS['sectors'][$data->sector];
                }
            ],
            [
                'attribute' => 'employeeAmount',
                'value'  => function($data){
                    return $GLOBALS['employees'][$data->employeeAmount];
                }
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}'
            ],
        ],
    ]); ?>

</div>
