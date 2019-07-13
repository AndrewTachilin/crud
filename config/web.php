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
    'modules'      => [

        'lte' =>[
            'class' => 'app\modules\adminlte\Module',
            'layout' => 'main',
        ],
        'adminlle' => [
            'class' => 'app\modules\adminlte\Module',

        ],
        'rbac' => [
            'class' => 'mdm\admin\Module',
            'controllerMap' => [
                'assignment' => [
                    'class' => 'mdm\admin\controllers\AssignmentController',
                    /* 'userClassName' => 'app\models\User', */
                    'idField' => 'id',
                    'usernameField' => 'username',
                ],
            ],
            'layout' => 'left-menu',
            'mainLayout' => '@app/views/layouts/main.php'
        ]

    ],'as access' => [
        'class' => 'mdm\admin\components\AccessControl',
        'allowActions' => [
            '*'
//            'site/*',
//            'blog/*',
//            'account/login',
//            'admin/*',
//            'rbac/*',
//            'account/*',
//            'registration/*',
//            'auth/*',
//            'AuthHandler/*',
//            'gii/*',
//            'translatemanager/*',
//            'lte/*',
//            'debug/*',
//            'post/*',
//            'language/*',
//            'countries/*'
            //'post/index'
            //The actions listed here will be allowed to everyone including guests.
            //So, 'admin/*' should not appear here in the production, of course.
            //But in the earlier stages of your development, you may probably want to
            //add a lot of actions here until you finally completed setting up rbac,
            //otherwise you may not even take a first step.
        ]
    ],
    'components' => [
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'qqwe',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'mdm\admin\models\User',
            'loginUrl' => ['rbac/user/login'],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
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
            'enablePrettyUrl'      => true,
            'enableStrictParsing'  => false,
            'showScriptName'       => false,
            'rules' => [
                'admin/user/<id:\d+>'                       => 'admin/user/view',
                'admin/index'                               => 'countries/default/index',
                'admin/rbac'                                => 'admin/access/role',
                'admin/permission'                          => 'admin/access/permission',
                'admin/add-permission'                      => 'admin/access/add-permission',
                'admin/create'                              => 'countries/default/create',
                'admin/login'                               => 'countries/default/login',
                'admin/logout'                              => 'admin/logout',
                'admin/update'                              => 'countries/default/update',
                'view'                                      => 'ApplicationManagement/index'
            ],
        ],

    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['*'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['*'],
    ];
}

return $config;
