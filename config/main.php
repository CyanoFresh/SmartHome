<?php

$params = require(__DIR__ . '/params.php');

return [
    'id' => 'solomaha-home',
    'name' => 'Solomaha Home',
    'language' => 'ru',
    'sourceLanguage' => 'ru',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
            'loginUrl' => ['/auth/login'],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@app/mail',
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
        'db' => require(__DIR__ . '/db.php'),
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '' => 'panel/index',
                '<controller>' => '<controller>/index',
                'profile/<id:\d+>' => 'profile/index',
                'admin/<controller>/<id:\d+>/<action:(create|update|delete)>' => 'admin/<controller>/<action>',
                'admin/<controller>/<id:\d+>' => 'admin/<controller>/view',
                'admin/<controller>s' => 'admin/<controller>/index',
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['api/room', 'api/item'],
                    'pluralize' => false,
                ],
            ],
        ],
        'view' => [
            'class' => 'rmrevin\yii\minify\View',
            'minify_path' => '@webroot/assets',
            'force_charset' => 'UTF-8',
        ],
        'formatter' => [
            'defaultTimeZone' => 'Europe/Kiev',
            'timeZone' => 'Europe/Kiev',
        ],
        'assetManager' => [
            'appendTimestamp' => true,
            'bundles' => [
                'yii\bootstrap\BootstrapAsset' => [
                    'css' => [],
                ],
            ],
        ],
    ],
    'modules' => [
        'admin' => [
            'class' => 'app\modules\admin\Module',
        ],
        'api' => [
            'class' => 'app\modules\api\Module',
        ],
        'datecontrol' => [
            'class' => '\kartik\datecontrol\Module'
        ],
    ],
    'params' => $params,
    'defaultRoute' => ['panel/index'],
];
