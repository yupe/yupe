<?php

return [
    'module' => [
        'class' => 'application.modules.manualpay.ManualPayModule',
    ],
    'component' => [
        'paymentManager' => [
            'paymentSystems' => [
                'manualpay' => [
                    'class' => 'application.modules.manualpay.components.payments.ManualPaymentSystem',
                ]
            ],
        ],
    ],
];
