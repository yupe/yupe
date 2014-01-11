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

        'userManager' => array(
            'class' => 'application.modules.user.components.UserManager',
            'hasher' => array(
                'class' => 'application.modules.user.components.Hasher'
            ),
            'tokenStorage' => array(
                'class' => 'application.modules.user.components.TokenStorage',
            )
        ),
        'authenticationManager' => array(
            'class' => 'application.modules.user.components.AuthenticationManager'
        ),
        'notify' => array(
            'class' => 'yupe\components\Notify',
            'mail' => array(
                'class' => 'yupe\components\Mail'
            )
        )
    ),

    'rules'     => array(
        '/login'                 => 'user/account/login',
        '/backend/login'         => 'user/account/backendlogin',
        '/logout'                => 'user/account/logout',
        '/registration'          => 'user/account/registration',
        '/recovery'              => 'user/account/recovery',
        '/users'                 => 'user/people/index',
        '/profile'               => 'user/account/profile',
        '/users/<username:\w+>/' => 'user/people/userInfo',
        '/activate/<token>'      => 'user/account/activate',
        '/confirm/<token>'       => 'user/account/confirm',
        '/recovery/<token>'      => 'user/account/restore',
        '/user/account/captcha/refresh/<v>' => 'user/account/captcha/refresh',
        '/user/account/captcha/<v>' => 'user/account/captcha/'
    ),
);
