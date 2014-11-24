<?php

return [
    'module' => [
        'class' => 'application.modules.yandexmarket.YandexMarketModule',
    ],
    'rules' => [
        '/yandexmarket/export/<id:\d+>' => 'yandexmarket/export/view',
    ],
];
