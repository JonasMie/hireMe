<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'authClientCollection' => [
            'class' => 'yii\authclient\Collection',
            'clients' => [
                'facebook' => [
                    'class' => 'yii\authclient\clients\Facebook',
                    'clientId' => '751087841674690',
                    'clientSecret' => 'eb48650a55ff164e5ff6bb123738c4b9',
                ],
                'google' => [
                    'class' => 'yii\authclient\clients\GoogleOAuth',
                    'clientId' => '58721707988-v5app0rim8mk4pqan11dq8hh95nvph2o.apps.googleusercontent.com',
                    'clientSecret' => 'sNlR14tzduh9Z1n9SXyYodKZ'
                ],
                'twitter' => [
                    'class' => 'yii\authclient\clients\Twitter',
                    'consumerKey' => '8ULtNfLiZJrvl5TanxDUkMEAg',
                    'consumerSecret' => '2bnacVzOy4s5UgLXX72ApvAqZnkMEj32GfGhQFq5hRmYsJ0cyi',
                ],
                'linkedin' => [
                    'class' => 'yii\authclient\clients\LinkedIn',
                    'clientId' => '75g3owrkn1hj8d',
                    'clientSecret' => 'SJDPnnOxD9e1qsUi',
                ]

            ],
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
        ],
        'formatter'  => [
            'defaultTimeZone' => 'EET',
            'timeZone'        => 'Europe/Berlin',
        ]
    ],
    'params' => $params,
];
