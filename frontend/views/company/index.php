<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\CompanySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('company', 'Company');
?>
<div class="company-index">

    <h1><?= Html::encode($this->title) ?></h1>


    <? include Yii::getAlias('@helper/companySignup.php');
    $GLOBALS['sectors'] = $sectorList;
    $GLOBALS['employees'] = $employeeAmount; ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'emptyCell'    => '&nbsp;',
        'columns'      => [
            [
                'attribute' => 'name',
                'format'    => 'raw',
                'value'     => function ($data) {
                    return Html::a($data->name, ['/company/view', 'id' => $data->id]);
                }
            ],
            [
                'attribute' => 'city',
                'value' => function ($data){
                    if($data->city){
                        return $data->city;
                    }
                    return '';
                }
            ],
            [
                'attribute' => 'sector',
                'value'     => function ($data) {
                    if ($data->sector) {
                        return $GLOBALS['sectors'][$data->sector];
                    }
                    return '';
                },
            ],
            [
                'attribute' => 'employeeAmount',
                'value'     => function ($data) {
                    if ($data->employeeAmount) {
                        return $GLOBALS['employees'][$data->employeeAmount];
                    }
                    return '';
                }
            ],

            [
                'class'    => 'yii\grid\ActionColumn',
                'template' => '{view}'
            ],
        ],
    ]); ?>

</div>
