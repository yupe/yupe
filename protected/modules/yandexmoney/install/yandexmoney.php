<?php

return [
    'module' => [
        'class' => 'application.modules.yandexmoney.YandexMoneyModule',
    ],
    'component' => [
        'paymentManager' => [
            'paymentSystems' => [
                'yandexmoney' => [
                    'class' => 'application.modules.yandexmoney.components.payments.YandexMoneyPaymentSystem',
                ]
            ],
        ],
    ],
];
