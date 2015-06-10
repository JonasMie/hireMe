<?php
/**
 * Created by Jonas Miederer.
 * User: jonas
 * Date: 08.06.15
 * Time: 00:49
 * Project: hireMe
 *
 * @var $edit boolean
 */

use kartik\datecontrol\DateControl;
use kartik\detail\DetailView;
use yii\helpers\Html;


$attributes = [
    'graduation:text:Abschluss',
    'schoolname:text:Schule',
    [
        'label'     => 'Von',
        'attribute' => 'begin',
        'format'=>['date', 'php:d.m.Y'],
        'type'=>DetailView::INPUT_WIDGET,
        'widgetOptions'=>[
            'class'=>DateControl::classname(),
            'type'=>DateControl::FORMAT_DATE
        ]
    ],
    [
        'label'     => 'Bis',
        'format'    => ['date', 'php:d.m.Y'],
        'attribute' => 'end',
        'type'=>DetailView::INPUT_WIDGET,
        'widgetOptions'=>[
            'class'=>DateControl::classname(),
            'type'=>DateControl::FORMAT_DATE
        ]
    ],
    [
        'attribute' => 'id',
        'format'=> 'raw',
        'value' => Html::activeHiddenInput($model, 'id'),
        'rowOptions'=>['style'=>'display:none'],
        'type'      => DetailView::INPUT_HIDDEN
    ],
];
if (!empty($model->report)) {
    array_push($attributes, [
        'label'  => 'Anhänge',
        'value'  => Html::a($model->report->title . "." . $model->report->extension, "/uploads/messattachments" . $model->report->path . "." . $model->report->extension),
        'format' => 'raw'
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
    'panel'=>[
        'heading'=> $model->graduation,
        'type' => DetailView::TYPE_DEFAULT      // STYLE: Panel-Style ist mit den Bootstrap-Context-Types anpassbar (z.B. TYPE_PRIMARY)
    ],
    'deleteOptions'=>[
        'params' => ['id' => $model->id, 'type' => 'school'],
        'url'=>['delete'],
    ],
    'enableEditMode' => $edit,
]);