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
    [
        'label'     => 'Abschluss',
        'attribute' => 'graduation',
		'inputContainer' => ['class'=>'allowPrefill'],
    ],
	[
        'label'     => 'Einrichtung',
        'attribute' => 'schoolname',
		'inputContainer' => ['class'=>'allowPrefill'],
    ],
	[
        'label'     => 'Von',
        'attribute' => 'begin',
        'format'=>['date', 'php:d.m.Y'],
        'type'=>DetailView::INPUT_WIDGET,
        'widgetOptions'=>[
            'class'=>DateControl::classname(),
            'type'=>DateControl::FORMAT_DATE,
            'options' => ['id' => 'school-date-begin-' . $model->id, 'class'=>'allowPrefill']
        ],
		'inputContainer' => ['class'=>'allowPrefill'],
    ],
    [
        'label'     => 'Bis',
        'format'    => ['date', 'php:d.m.Y'],
        'attribute' => 'end',
        'type'=>DetailView::INPUT_WIDGET,
        'widgetOptions'=>[
            'class'=>DateControl::classname(),
            'type'=>DateControl::FORMAT_DATE,
            'options' => ['id' => 'school-date-end-' . $model->id, 'class'=>'allowPrefill']
        ],
		'inputContainer' => ['class'=>'allowPrefill'],
    ],
    [
        'attribute' => 'current',
        'rowOptions' => ['class'=>'kv-view-hidden'],
        'type' => DetailView::INPUT_CHECKBOX,
        'label' => ''
    ],
    [
        'label'     => 'Anhänge',
        'attribute' => 'report_id',
        'value' =>     $model->report? Html::a($model->report->title . "." . $model->report->extension, "/uploads/reports" . $model->report->path . "." . $model->report->extension,['target'=>'_blank']):null,
        'format'    => 'raw',
        'type' => DetailView::INPUT_FILE,
    ],
    [
        'attribute' => 'id',
        'format'=> 'raw',
        'value' => Html::activeHiddenInput($model, 'id'),
        'rowOptions'=>['style'=>'display:none'],
        'type'      => DetailView::INPUT_HIDDEN
    ],

];

echo DetailView::widget([
	'bootstrap' => false,
    'model'          => $model,
    'attributes'     => $attributes,
    'panel'          => [
        'heading' => $model->graduation,
        'type'    => DetailView::TYPE_SUCCESS      // STYLE: Panel-Style ist mit den Bootstrap-Context-Types anpassbar (z.B. TYPE_PRIMARY)
    ],
    'deleteOptions'  => [
        'params' => ['id' => $model->id, 'type' => 'school'],
        'url'    => ['delete'],
		'label'  => '<span class="glyphicon glyphicon-trash"></span>',
    ],
	'viewOptions'  => [
		'label'  => '<span class="glyphicon glyphicon-arrow-left"></span>',
	],
	'resetOptions'  => [
		'label'  => '<span class="glyphicon glyphicon-remove"></span>',
	],
    'hideIfEmpty'    => true,
    'formOptions'    => ['options' => ['enctype' => 'multipart/form-data']],
    'enableEditMode' => $edit,
	'hAlign' => DetailView::ALIGN_LEFT,
	'vAlign' => 'top',
]);