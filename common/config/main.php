<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',

        '@webPath' => \Yii::getAlias('@public'),
        '@webUrl' => '/',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager', // or use 'yii\rbac\PhpManager'
        ]
    ],
    'charset' => 'utf-8',
    'language' => 'zh-CN',
    'name' => 'Yii2Bolg',
    'timeZone' => 'Asia/Shanghai'
];
