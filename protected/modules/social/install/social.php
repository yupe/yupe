<?php
return array(
    'module'    => array(
        'class' => 'application.modules.social.SocialModule',
    ),
    'import'    => array(
        'application.modules.social.widgets.ysc.*',
        'application.modules.social.components.*',
        'application.modules.social.models.*',
        'application.modules.social.extensions.eoauth.*',
        'application.modules.social.extensions.eoauth.lib.*',
        'application.modules.social.extensions.lightopenid.*',
        'application.modules.social.extensions.eauth.services.*',
    ),
    'component' => array(
        // подключение библиотеки для авторизации через социальные сервисы, подробнее: https://github.com/Nodge/yii-eauth
        'loid' => array(
            'class' => 'application.modules.social.extensions.lightopenid.loid',
        ),
        // экстеншн для авторизации через социальные сети подробнее: http://habrahabr.ru/post/129804/
        'eauth' => array(
            'class'    => 'application.modules.social.extensions.eauth.EAuth',
            'popup'    => true,  // use the popup window instead of redirecting.
            'services' => array( // you can change the providers and their classes.
                'google' => array('class' => 'CustomGoogleService'),
                'yandex' => array('class' => 'CustomYandexService'),
            ),
        ),
    ),
    'rules'     => array(),
);