<?php

$params = require __DIR__ . '/params.php';
$db     = require __DIR__ . '/db.php';

$config = [
    'id'                  => 'basic-console',
    'basePath'            => dirname(__DIR__),
    'bootstrap'           => ['log'],
    'controllerNamespace' => 'app\commands',
    'aliases'             => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
        '@tests' => '@app/tests',
    ],
    'components'          => [
        'authManager' => [
            'class' => yii\rbac\DbManager::class,
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'log'   => [
            'targets' => [
                [
                    'class'  => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db'    => $db,
    ],
    'params'              => $params,

    'controllerMap' => [
        'migrate-mysql'   => [
            'class'          => 'yii\console\controllers\MigrateController',
            'migrationPath'  => [
                '@app/migrations/mysql',
                '@yii/rbac/migrations',
                __DIR__ . '/../vendor/mdmsoft/yii2-admin/migrations'
//                '@mdm/admin/migrations',
            ],
            'migrationTable' => 'migration',
        ],

        // Menu migrations
        'migrate-menu'    => [
            'class'          => 'yii\console\controllers\MigrateController',
            'migrationPath'  => [
                '@app/migrations/menu',
            ],
            'migrationTable' => 'migration_menu',
        ],

        // RBAC migrations
        'migrate-rbac'    => [
            'class'          => 'yii\console\controllers\MigrateController',
            'migrationPath'  => [
                '@app/migrations/rbac',
            ],
            'migrationTable' => 'migration_rbac',
        ],
    ],

];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][]    = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
