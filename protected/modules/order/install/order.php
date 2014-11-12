<?php

return array(
    'module' => array(
        'class' => 'application.modules.order.OrderModule',
    ),
    'import' => array(
        'application.modules.order.models.*',
    ),
    'component' => array(
        'eventManager'   => array(
            'class'  => 'yupe\components\EventManager',
            'events' => array(
                'order.pay.success' => array(
                    array('PayOrderListener', 'onSuccessPay')
                ),
            )
        )
    ),
    'rules' => array(
        '/order/<url:\w+>' => 'order/order/view',
        '/store/order/<action:\w+>' => 'order/order/<action>',
        '/store/account' => 'order/user/index',
        '/store/account/<action:\w+>' => 'order/user/<action>',
    ),
);
