<?php
return array(
    'module'    => array(
        'class'            => 'application.modules.user.UserModule',
        'panelWidgets'     => array(
            'application.modules.user.widgets.PanelUserStatWidget' => array(
                'limit' => 5
            )
        ),
        'documentRoot'     => $_SERVER['DOCUMENT_ROOT'],
        'avatarsDir'       => 'avatars',
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
        'user'                  => array(
            'class'          => 'application.modules.user.components.YWebUser',
            'loginUrl'       => '/user/account/login/',
            'identityCookie' => array(
                'httpOnly' => true,
            ),
        ),
        'userManager'           => array(
            'class'        => 'application.modules.user.components.UserManager',
            'hasher'       => array(
                'class' => 'application.modules.user.components.Hasher'
            ),
            'tokenStorage' => array(
                'class' => 'application.modules.user.components.TokenStorage',
            )
        ),
        'authenticationManager' => array(
            'class' => 'application.modules.user.components.AuthenticationManager'
        ),
        'notify'                => array(
            'class' => 'yupe\components\Notify',
            'mail'  => array(
                'class' => 'yupe\components\Mail'
            )
        ),
        'eventManager'          => array(
            'class'  => 'yupe\components\EventManager',
            'events' => array(
                'user.success.registration'      => array(
                    array('UserManagerListener', 'onUserRegistration')
                ),
                'user.success.password.recovery' => array(
                    array('UserManagerListener', 'onPasswordRecovery')
                ),
                'user.success.activate.password' => array(
                    array('UserManagerListener', 'onSuccessActivatePassword')
                ),
                'user.success.email.confirm'     => array(
                    array('UserManagerListener', 'onSuccessEmailConfirm')
                ),
                'user.success.email.change'     => array(
                    array('UserManagerListener', 'onSuccessEmailChange')
                )
            )
        )
    ),
    'rules'     => array(
        '/login'                            => 'user/account/login',
        '/logout'                           => 'user/account/logout',
        '/registration'                     => 'user/account/registration',
        '/recovery'                         => 'user/account/recovery',
        '/users'                            => 'user/people/index',
        '/profile'                          => 'user/account/profile',
        '/profile/password'                 => 'user/account/profilePassword',
        '/profile/email'                    => 'user/account/profileEmail',
        '/users/<username:\w+>/'            => 'user/people/userInfo',
        '/activate/<token>'                 => 'user/account/activate',
        '/confirm/<token>'                  => 'user/account/confirm',
        '/recovery/<token>'                 => 'user/account/restore',
        '/user/account/captcha/refresh/<v>' => 'user/account/captcha/refresh',
        '/user/account/captcha/<v>'         => 'user/account/captcha/'
    ),
);
