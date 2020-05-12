<?php

return [
    'module' => [
        'class' => 'application.modules.yandexmoney3.YM3PayModule',
    ],
    'component' => [
        'paymentManager' => [
            'paymentSystems' => [
                'yandexmoney3' => [
                    'class' => 'application.modules.yandexmoney3.components.payments.YM3PaymentSystem',
                ]
            ],
        ],
    ],
    'rules' => [
        '/yandexmoney3/init' => 'yandexmoney3/payment/init',
    ],
];
