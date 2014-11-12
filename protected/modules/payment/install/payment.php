<?php

return array(
    'module' => array(
        'class' => 'application.modules.payment.PaymentModule',
    ),
    'import' => array(
        'application.modules.payment.models.*',
        'application.modules.payment.components.*',
    ),
    'component' => array(
        'request' => array(
            'noCsrfValidationRoutes' => array(
                'payment/process',
            ),
        ),
        'paymentManager' => array(
            'class' => 'application.modules.payment.components.PaymentManager'
        ),
    ),
    'rules' => array(
        '/payment/process/<id:\w+>' => 'payment/payment/process',
    ),
);
