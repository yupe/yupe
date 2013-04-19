<?php
return array(
    'module'    => array(
        'class'            => 'application.modules.user.UserModule',
        'documentRoot'     => $_SERVER['DOCUMENT_ROOT'],
        'avatarsDir'       => '/yupe/avatars',
        'avatarExtensions' => array( 'jpg', 'png', 'gif' ),
        'notifyEmailFrom'  => 'test@test.ru',
        'urlRules'         => array(
            'user/people/<username:\w+>/<mode:(topics|comments)>' => 'user/people/userInfo',
            'user/people/<username:\w+>'                          => 'user/people/userInfo',
            'user/people/'                                        => 'user/people/index',
        ),
        // 'attachedProfileEvents' => array("GeoModule"), // В случае использования GEO-модуля, подписываем его на события
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
        '/user/<username:\w+>/' => 'user/people/userInfo',
    ),
);
