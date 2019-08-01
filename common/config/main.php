<?php

require __DIR__.'/constant.php';

return [
    /*
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    */
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'charset' => 'utf-8',
    'components' => [
        //file cache
        'filecache' => [
            'class' => 'yii\caching\FileCache',
        ],
        //redis Cache
        'cache' => [
            'class' => 'common\components\Redis',
            'host' => '127.0.0.1',
            'port' => '6379',
            'database' => 0,
            'pconnect'=>1
        ],
        //default db
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=pyblog',
            'username' => 'pyblog',
            'password' => '123456',
            'charset' => 'utf8mb4',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
    ],
];
