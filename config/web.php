<?php

use yii\helpers\ArrayHelper;

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'name' => 'Library system',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log', 'search'],
    'timeZone' => 'Europe/Prague',
    'modules' => [
        'gridview' => [
            'class' => '\kartik\grid\Module',
        ],
        'search' => [
            'class' => '\kazda01\search\SearchModule',
            'searchConfig' => [
                'BookSearch' => [
                    'columns' => ['title', 'isbn'],
                    'matchTitle' => Yii::t('app', 'Books'),
                    'matchText' => function ($model) {
                        return "{$model->title} - {$model->author->name} ({$model->year_of_publication})";
                    },
                ],
                'AuthorSearch' => [
                    'columns' => ['name'],
                    'matchTitle' => Yii::t('app', 'Authors'),
                    'matchText' => function ($model) {
                        return "{$model->name} ({$model->getBooks()->count()})";
                    },
                    'route' => '/book/index',
                    'route_params' => function ($model) {
                        return ['BookSearch[authorName]' => $model->name];
                    },
                ],
            ]
        ],
    ],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'on beforeRequest' => function ($event) {
        if (!YII_DEBUG && !Yii::$app->request->isSecureConnection) {
            $url = Yii::$app->request->getAbsoluteUrl();
            $url = str_replace('http:', 'https:', $url);
            Yii::$app->getResponse()->redirect($url);
            Yii::$app->end();
        }
    },
    'components' => [
        'session' => [
            'class' => 'yii\web\DbSession',
            'writeCallback' => function ($session) {
                return [
                    'fk_user' => Yii::$app->user->id
                ];
            }
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'BlYXJybNY2y3z2VjmhbnRndWFyZGV4HJ',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => env('MAIL_HOST'),
                'username' => env('MAIL_USERNAME'),
                'password' => env('MAIL_PASS'),
                'port' => env('MAIL_PORT'),
                'encryption' => 'tls',
            ],
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
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [],
        ], 'assetManager' => [
            'appendTimestamp' => true,
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
    ],
    'params' => $params,
    'container' => [
        'definitions' => [
            \yii\widgets\LinkPager::class => \yii\bootstrap5\LinkPager::class,
            \yii\bootstrap5\LinkPager::class => [
                'options' => [
                    'class' => 'd-flex',
                ],
                'listOptions' => [
                    'class' => 'pagination mx-auto mt-3 mt-md-0',
                ],
                'linkOptions' => [
                    'class' => 'page-link text-dark',
                ],
            ],
            \yii\grid\ActionColumn::class => \kartik\grid\ActionColumn::class,
            \yii\grid\GridView::class => \kartik\grid\GridView::class,
        ],
    ],
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
