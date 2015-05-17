<?php

return [
    'module' => [
        'class' => 'application.modules.payment.PaymentModule',
    ],
    'import' => [
        'application.modules.payment.models.*',
        'application.modules.payment.components.*',
    ],
    'component' => [
        'request' => [
            'noCsrfValidationRoutes' => [
                '/payment/payment/process',
            ],
        ],
        'paymentManager' => [
            'class' => 'application.modules.payment.components.PaymentManager'
        ],
    ],
    'rules' => [
        '/payment/process/<id:\w+>' => 'payment/payment/process',
    ],
];
