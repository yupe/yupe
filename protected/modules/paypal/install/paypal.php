<?php

return array(
    'module' => array(
        'class' => 'application.modules.paypal.PayPalModule',
    ),
    'component' => array(
        'paymentManager' => array(
            'paymentSystems' => array(
                'paypal' => array(
                    'class' => 'application.modules.paypal.components.payments.PayPalPaymentSystem',
                )
            ),
        ),
    ),
    'rules'     => array(
        '/processPayPal'                        => '/paypal/paypal/index',
    ),
);
