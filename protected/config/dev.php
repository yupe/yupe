<?php

return CMap::mergeArray(
    require(dirname(__FILE__) . '/main.php'),
    [
        'preload' => defined('YII_DEBUG') && YII_DEBUG ? ['debug'] : [],
        'components' => [
            'debug' => ['class' => 'vendor.zhuravljov.yii2-debug.Yii2Debug', 'internalUrls' => true],
            'urlManager' => [
                'rules' => [
                    '/debug/<controller:\w+>/<action:\w+>' => 'debug/<controller>/<action>',
                ]
            ],
        ],
    ]
);