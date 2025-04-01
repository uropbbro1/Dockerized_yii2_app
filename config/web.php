<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            'cookieValidationKey' => 'tSI4h5oYba7tONZyZjiyjRPqBpQOqELK',
        ],
        'assetManager' => [
            'class' => 'yii\web\AssetManager',
            'appendTimestamp' => true,
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\NewUsers', // Используем новую модель
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => \yii\symfonymailer\Mailer::class,
            'viewPath' => '@app/mail',
            // send all mails to a file by default.
            'useFileTransport' => true,
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
            'rules' => [
                '/' => 'site/index',

                'comments' => 'get-reviews/get',
                'search-reviews-comments' => 'get-reviews/search',
                'add-review' => 'add-review/add',
                'update-review' => [
                    'pattern' => 'update-review',
                    'route' => 'update-review/update-review',
                    'defaults' => ['_csrf' => true],
                ],
                'sort-reviews' => 'sort-reviews/sort',
                'search-reviews' => [
                    'pattern' => 'search-reviews',
                    'route' => 'sort-reviews/search',
                    'defaults' => ['_csrf' => true],
                ],

                'authentication' => 'auth/authentication',
                'register' => 'auth/register',
                'auth' => 'auth/login',
                'password-recovery' => 'auth/password-recovery',

                'profile' => 'user/profile',
                'change-avatar' => 'user/change-avatar',
                'profile/update' => 'user/update-data',
                'change-password' => 'user/change-password',
                'check-password' => 'user/check-password',
                'logout' => 'auth/logout',

                'privacy-policy' => 'site/privacy-policy',
            ],
        ],
    ],
    'params' => array_merge(
        [
            'csrfCookie' => [
                'httpOnly' => true,
                'secure' => YII_ENV_PROD,
            ],
        ],
        $params
    ),
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
