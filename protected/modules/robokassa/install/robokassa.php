<?php

return [
    'module' => [
        'class' => 'application.modules.robokassa.RobokassaModule',
    ],
    'component' => [
        'paymentManager' => [
            'paymentSystems' => [
                'robokassa' => [
                    'class' => 'application.modules.robokassa.components.payments.RobokassaPaymentSystem',
                ]
            ],
        ],
    ],
];
