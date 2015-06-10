<?php
/**
 * Created by Jonas Miederer.
 * User: jonas
 * Date: 08.06.15
 * Time: 00:14
 * Project: hireMe
 */

use kartik\datecontrol\DateControl;
use kartik\detail\DetailView;
use yii\helpers\Html;
use yii\helpers\Url;


$attributes = [
    'type:text:Beschreibung',
    [
        'attribute' => 'company_id',
        'label'  => 'Arbeitgeber',
        'format' => 'raw',
        'value'  =>  Html::a($model->company->name, '/company'),
        'type' => DetailView::INPUT_TYPEAHEAD,
        'widgetOptions' => [
            'pluginOptions' => ['highlight' => true],
            'dataset'       => [
                [
                    'remote' => Url::to(['site/company-search' . '?q=%QUERY']),
                    'limit'  => 10,
                ],

            ],
            'options' => ['id'=>'typeahed-'.$model->id]
        ]
    ],
    [
        'label'         => 'Von',
        'attribute'     => 'begin',
        'format'        => ['date', 'php:d.m.Y'],
        'type'          => DetailView::INPUT_WIDGET,
        'widgetOptions' => [
            'class' => DateControl::classname(),
            'type'  => DateControl::FORMAT_DATE,
            'options' => ['id'=>'date-begin-'.$model->id]
        ]
    ],
    [
        'label'         => 'Bis',
        'format'        => ['date', 'php:d.m.Y'],
        'attribute'     => 'end',
        'type'          => DetailView::INPUT_WIDGET,
        'widgetOptions' => [
            'class' => DateControl::classname(),
            'type'  => DateControl::FORMAT_DATE,
            'options' => ['id'=>'date-end-'.$model->id]
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
//if (!empty($model->report)) {
//    array_push($attributes, [
//        'label'     => 'Anhänge',
//        'attribute' => function () use ($model) {
//            return Html::a($model->report->title . "." . $model->report->extension, "/uploads/messattachments" . $model->report->path . "." . $model->report->extension);
//        },
//        'format'    => 'raw'
//    ]);
//}

echo DetailView::widget([
    'model'         => $model,
    'attributes'    => $attributes,
    'panel'         => [
        'heading' => $model->type,
        'type'    => DetailView::TYPE_DEFAULT      // STYLE: Panel-Style ist mit den Bootstrap-Context-Types anpassbar (z.B. TYPE_PRIMARY)
    ],
    'deleteOptions' => [
        'params' => ['id' => $model->id, 'type' => 'job'],
        'url'    => ['delete'],
    ],
]);
