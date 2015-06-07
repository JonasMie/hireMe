<?php
/**
 * Created by Jonas Miederer.
 * User: jonas
 * Date: 08.06.15
 * Time: 00:49
 * Project: hireMe
 */

use yii\helpers\Html;
use yii\widgets\DetailView;

$attributes = [
    'graduation:text:Abschluss',
    'schoolname:text:Schule',
    [
        'label'     => 'Von',
        'format'    => ['date', 'php:m.Y'],
        'attribute' => 'begin',
    ],
    [
        'label'     => 'Bis',
        'format'    => ['date', 'php:m.Y'],
        'attribute' => 'end',
    ],
];
if (!empty($model->report)) {
    array_push($attributes, [
        'label'     => 'Anhänge',
        'attribute' => function () use ($model) {
            return Html::a($model->report->title . "." . $model->report->extension, "/uploads/messattachments" . $model->report->path . "." . $model->report->extension);
        },
        'format'    => 'raw'
    ]);
}

//array_push($attributes, [
//    'attribute' => '',
//    'label' => 'Aktionen',
//    'class'    => 'yii\grid\ActionColumn',
//    'template' => '{update}{delete}'
//]);

echo DetailView::widget([
    'model'      => $model,
    'attributes' => $attributes,
]);