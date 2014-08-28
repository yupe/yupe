<?php

return array(
    'module'    => array(
        'class' => 'application.modules.rbac.RbacModule'
    ),
    'import'    => array(
        'application.modules.rbac.listeners.AccessControlListener'
    ),
    'component' => array(
        'authManager'   => array(
            'class'           => 'CDbAuthManager',
            'connectionID'    => 'db',
            'assignmentTable' => '{{user_user_auth_assignment}}',
            'itemChildTable'  => '{{user_user_auth_item_child}}',
            'itemTable'       => '{{user_user_auth_item}}',
        ),
        // override core ModuleManager
        'moduleManager' => array(
            'class' => 'application.modules.rbac.components.ModuleManager'
        ),
        //attach event handlers
        'eventManager'  => array(
            'class'  => 'yupe\components\EventManager',
            'events' => array(
                // before backend controllers
                'yupe.backend.controller.init' => array(
                    array('AccessControlListener', 'onBackendControllerInit')
                )
            )
        )
    ),
    'rules'     => array(
        '/backend/rbac/<controller:\w+>/<action:\w+>/<id:[\w._-]+>' => 'rbac/<controller>Backend/<action>',
    ),
);
