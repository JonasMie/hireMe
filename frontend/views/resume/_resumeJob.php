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


    [
        'attribute'     => 'company_id',
        'label'         => 'Unternehmen',
        'format'        => 'raw',
        'value'         => Html::a($model->company->name, ['/company/view', 'id' => $model->company->id]), // TODO: check company url
        'type'          => DetailView::INPUT_TYPEAHEAD,
        'widgetOptions' => [
            'pluginOptions' => ['highlight' => true],
            'dataset'       => [
                [
                    'remote' => Url::to(['site/company-search' . '?q=%QUERY']),
                    'limit'  => 10,
                ],

            ],
            'options'       => ['id' => 'typeahead-' . $model->id, 'value' => $model->company->name, 'class' => 'allowPrefill'],
            'container'     => ['class' => 'allowPrefill'],
        ],
    ],
    [
        'attribute' => 'description',
        'format'    => 'ntext',
        'type'      => 'textArea',
        'label'     => 'Beschreibung',
    ],
    [
        'label'          => 'Von',
        'attribute'      => 'begin',
        'format'         => ['date', 'php:d.m.Y'],
        'type'           => DetailView::INPUT_WIDGET,
        'widgetOptions'  => [
            'class'   => DateControl::classname(),
            'type'    => DateControl::FORMAT_DATE,
            'options' => [
                'options' => ['id' => 'job-date-begin-', 'class' => 'form-control allowPrefill'],
            ],


        ],
        'inputContainer' => ['class' => 'allowPrefill'],
    ],
    [
        'label'          => 'Bis',
        'format'         => ['date', 'php:d.m.Y'],
        'attribute'      => 'end',
        'type'           => DetailView::INPUT_WIDGET,
        'widgetOptions'  => [
            'class'   => DateControl::classname(),
            'type'    => DateControl::FORMAT_DATE,
            'options' => ['id' => 'job-date-end-' . $model->id, 'class' => 'allowPrefill']
        ],
        'inputContainer' => ['class' => 'allowPrefill'],
    ],
    [    // TODO: add possibility to remove file
        'label'     => '',
        'attribute' => 'report_id',
        'value'     => $model->report ? Html::a($model->report->title . "." . $model->report->extension, "/uploads/reports" . $model->report->path . "." . $model->report->extension, ['target' => '_blank']) : null,
        'format'    => 'raw',
        'type'      => DetailView::INPUT_FILE,
    ],
    [
        'attribute'  => 'id',
        'format'     => 'raw',
        'value'      => Html::activeHiddenInput($model, 'id'),
        'rowOptions' => ['style' => 'display:none'],
        'type'       => DetailView::INPUT_HIDDEN
    ],
    [
        'attribute'  => 'current',
        'rowOptions' => ['class' => 'kv-view-hidden'],
        'type'       => DetailView::INPUT_CHECKBOX,
    ],
];

echo DetailView::widget([
    'bootstrap'      => false,
    'model'          => $model,
    'attributes'     => $attributes,
    'panel'          => [
        'heading' => $model->type,
        'type'    => DetailView::TYPE_SUCCESS      // STYLE: Panel-Style ist mit den Bootstrap-Context-Types anpassbar (z.B. TYPE_PRIMARY)
    ],
    'deleteOptions'  => [
        'params' => ['id' => $model->id, 'type' => 'job'],
        'url'    => ['delete'],
        'label'  => '<span class="glyphicon glyphicon-trash"></span>',
    ],
    'hideIfEmpty'    => true,
    'formOptions'    => ['options' => ['enctype' => 'multipart/form-data']],
    'enableEditMode' => $edit,
    'hAlign'         => DetailView::ALIGN_LEFT,
]);
