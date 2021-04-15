<?php

return [
    'module' => [
        'class' => 'application.modules.tinkoffpay.TinkoffPayModule',
    ],
    'component' => [
        'paymentManager' => [
            'paymentSystems' => [
                'tinkoffpay' => [
                    'class' => 'application.modules.tinkoffpay.components.payments.TinkoffPaymentSystem',
                ]
            ],
        ],
    ],
    'rules' => [
        '/tinkoffpay/init/<orderId:\w+>' => 'tinkoffpay/payment/init',
    ],
];
