<?php

return array(
    'module' => array(
        'class' => 'application.modules.robokassa.RobokassaModule',
    ),
    'component' => array(
        'paymentManager' => array(
            'paymentSystems' => array(
                'robokassa' => array(
                    'class' => 'application.modules.robokassa.components.payments.RobokassaPaymentSystem',
                )
            ),
        ),
    ),
);
