<?php
return array(
    'module'    => array(
        'class'            => 'application.modules.user.UserModule',
        'documentRoot'     => $_SERVER['DOCUMENT_ROOT'],
        'avatarsDir'       => 'avatars',
        'avatarExtensions' => array( 'jpg', 'png', 'gif' ),
        'notifyEmailFrom'  => 'test@test.ru'
    ),
    'import'    => array(
        'application.modules.user.UserModule',
        'application.modules.user.models.*',
        'application.modules.user.forms.*',
        'application.modules.user.components.*',
    ),
    'component' => array(
        // компонент Yii::app()->user, подробнее http://www.yiiframework.ru/doc/guide/ru/topics.auth
        'user' => array(
            'class'    => 'application.modules.user.components.YWebUser',
            'loginUrl' => '/user/account/login/',
        ),
    ),
    'rules'     => array(
        '/login'                => 'user/account/login',
        '/yupe/backend/login'   => 'user/account/backendlogin',
        '/logout'               => 'user/account/logout',
        '/registration'         => 'user/account/registration',
        '/recovery'             => 'user/account/recovery',
        '/users'                => 'user/people/index',
        '/profile'              => 'user/account/profile',
        '/users/<username:\w+>/' => 'user/people/userInfo',
        '/activate/<key>'     => 'user/account/activate',
        '/confirm/<key>'      => 'user/account/confirm',
        '/recovery/<key>'     => 'user/account/restore'
    ),
);
