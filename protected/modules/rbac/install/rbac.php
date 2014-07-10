<?php return array(
    'module' => array(
        'class' => 'application.modules.rbac.RbacModule'
    ),
    'component' => array(
        'authManager' => array(
            'class' => 'CDbAuthManager',
            'connectionID' => 'db',
            'assignmentTable' => '{{user_user_auth_assignment}}',
            'itemChildTable' => '{{user_user_auth_item_child}}',
            'itemTable' => '{{user_user_auth_item}}',
        ),
    ),
    'rules' => array(
        '/backend/rbac/<controller:\w+>/<action:\w+>/<id:\w+._->' => 'rbac/<controller>Backend/<action>',
    ),
);