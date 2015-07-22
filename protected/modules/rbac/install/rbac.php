<?php

return [
    'module' => [
        'class' => 'application.modules.rbac.RbacModule'
    ],
    'import' => [
        'application.modules.rbac.listeners.AccessControlListener'
    ],
    'component' => [
        'authManager' => [
            'class' => 'CDbAuthManager',
            'connectionID' => 'db',
            'assignmentTable' => '{{user_user_auth_assignment}}',
            'itemChildTable' => '{{user_user_auth_item_child}}',
            'itemTable' => '{{user_user_auth_item}}',
        ],
        // override core ModuleManager
        'moduleManager' => [
            'class' => 'application.modules.rbac.components.ModuleManager'
        ],
        //attach event handlers
        'eventManager' => [
            'class' => 'yupe\components\EventManager',
            'events' => [
                // before backend controllers
                'yupe.backend.controller.init' => [
                    ['AccessControlListener', 'onBackendControllerInit']
                ]
            ]
        ]
    ],
    'rules'     => [
        '/backend/rbac/<controller:\w+>/<action:\w+>/<id:[\w._-]+>' => 'rbac/<controller>Backend/<action>',
    ],
];
