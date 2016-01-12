<?php

return [
    'module' => [
        'class' => 'application.modules.payler.PaylerModule',
    ],
    'component' => [
        'paymentManager' => [
            'paymentSystems' => [
                'payler' => [
                    'class' => 'application.modules.payler.components.payments.PaylerPaymentSystem',
                ]
            ],
        ],
    ],
];
