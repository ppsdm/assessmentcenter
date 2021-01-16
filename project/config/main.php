<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-project',
    'name' => 'PPSDM Assessment Center',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'project\controllers',
    'aliases' => [
        '@tcpdf' => '@vendor/reno/tcpdf',
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-project',
        ],
        'user' => [

            'identityClass' => 'project\models\ProjectUser',

            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-project', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-project',
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
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => true,
            'enableStrictParsing' => false,
            'rules' => [
                '<controller:\w+>/<id:\d+>'=>'<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
                '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
            ],
        ],

        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'encryption' => 'ssl',
                'host' => 'smtp.titan.email',
                'port' => '465',
                'username' => 'management@ppsdm.com',
                'password' => 'p32n151181',
//                'encryption' => 'tls',
//                'host' => 'smtp.gmail.com',
//                'port' => '587',
//                'username' => 'renowijoyo@gmail.com',
//                'password' => 'RAN4ever#',
            ],
        ],

    ],
    'params' => $params,
];
