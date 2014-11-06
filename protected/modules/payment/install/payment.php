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
            'class' => 'application.modules.payment.components.PaymentManager',
            'paymentSystems' => array(
                /* 'robokassa' => array(
                    'class' => 'application.modules.robokassa.components.payments.RobokassaPaymentSystem',
                )*/
            ),
        ),
    ),
    'rules' => array(
        '/payment/process/<id:\w+>' => 'payment/payment/process',
    ),
);
