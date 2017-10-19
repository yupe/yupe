<?php

return [
    'module' => [
        'class' => 'application.modules.order.OrderModule',
        'panelWidgets' => [
            'application.modules.order.widgets.PanelOrderStatWidget' => [
                'limit' => 5
            ]
        ],
    ],
    'import' => [
        'application.modules.order.models.*',
        'application.modules.order.helpers.*',
    ],
    'component' => [
        'eventManager' => [
            'class' => 'yupe\components\EventManager',
            'events' => [
                'order.pay.success' => [
                    ['PayOrderListener', 'onSuccessPay']
                ],
                'order.create.success' => [
                    ['OrderListener', 'onCreate']
                ]
            ]
        ],
        'orderNotifyService' => [
            'class' => 'application.modules.order.components.OrderNotifyService',
            'mail'  => 'mail'
        ],
    ],
    'rules' => [
        '/order/check'    => '/order/order/check',
        '/order/<url:\w+>' => 'order/order/view',
        '/store/order/<action:\w+>' => 'order/order/<action>',
        '/store/account' => 'order/user/index',
        '/store/account/<action:\w+>' => 'order/user/<action>',
    ],
];
