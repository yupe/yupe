<?php return array(
    'module' => array(
        'class' => 'application.modules.rbac.RbacModule'
    ),
    'component'=>array(
        'authManager'=>array(
            'class'=>'CDbAuthManager',
            'showErrors' => true,
            'itemTable'=>'user_user_auth_item',
            'itemChildTable'=>'user_user_auth_item_child',
            'assignmentTable'=>'user_user_auth_assignment',
            'connectionID'=>'db',
            // Роль по умолчанию. Все, кто не админы, модераторы и юзеры — гости.
            'defaultRoles' => array('guest'),
        )
    ),
    'rules'=>array(
        '/backend/rbac/<action:\w+>'	=> 'rbac/rbacBackend/<action>',
        '/backend/rbac/<action:\w+>/<id:\w+>'	=> 'rbac/rbacBackend/<action>', // Для модуля rbac id передается в виде строки а не числового идентификатора
    )
);