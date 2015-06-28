<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache'      => [
            'class' => 'yii\caching\FileCache',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName'  => false,
            'rules'           => [
                'user/settings' => 'user/settings',
                'user/<un:\w+>' => 'user',
            ]
        ],
        'i18n' => [
            'translations' => [
                'user' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                ],
                'company' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                ],
                'application'=> [
                    'class' => 'yii\i18n\PhpMessageSource',
                ],
                'file' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                ],
                'geo'=> [
                    'class' => 'yii\i18n\PhpMessageSource',
                ],
                'job'=> [
                    'class' => 'yii\i18n\PhpMessageSource',
                ],
                'resume'=> [
                    'class' => 'yii\i18n\PhpMessageSource',
                ],
            ],
        ],
    ],
    'modules'    => [
        'datecontrol' => [
            'class'           => 'kartik\datecontrol\Module',

            // format settings for displaying each date attribute
            'displaySettings' => [
                'date'     => 'php:d.m.Y',
                'time'     => 'php:H:i:s A',
                'datetime' => 'php:d.m.Y H:i:s A',
            ],

            // format settings for saving each date attribute
            'saveSettings'    => [
                'date'     => 'php:Y-m-d',
                'time'     => 'php:H:i:s',
                'datetime' => 'php:Y-m-d H:i:s',
            ],

            // automatically use kartikwidgets for each of the above formats
            'autoWidget'      => true,
        ],
    ],

    'language'   => 'de',
];
