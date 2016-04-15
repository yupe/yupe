<?php
return [
    'module'    => [
        'class' => 'application.modules.social.SocialModule',
    ],
    'component' => [
        'eauth' => [
            'class'    => 'vendor.nodge.yii-eauth.EAuth',
            'popup'    => false,
            'services' => [
                'google'    => [
                    'class'         => 'application\modules\social\components\services\Google',
                    'client_id'     => '',
                    'client_secret' => '',
                ],
                'twitter'   => [
                    // register your app here: https://dev.twitter.com/apps/new
                    'class'  => 'application\modules\social\components\services\Twitter',
                    'key'    => '',
                    'secret' => '',
                ],
                'facebook'  => [
                    // register your app here: https://developers.facebook.com/apps/
                    'class'         => 'application\modules\social\components\services\Facebook',
                    'client_id'     => '',
                    'client_secret' => '',
                    'scope'         => 'email',
                ],
                'vkontakte' => [
                    // register your app here: https://vk.com/editapp?act=create&site=1
                    'class'         => 'application\modules\social\components\services\VKontakte',
                    'client_id'     => '',
                    'client_secret' => '',
                    'title'         => 'VKontakte',
                ],
                'github'    => [
                    // register your app here: https://github.com/settings/applications
                    'class'         => 'application\modules\social\components\services\Github',
                    'client_id'     => '',
                    'client_secret' => '',
                ],
            ],
        ],
        'loid'  => [
            'class' => 'vendor.itmages.lightopenid.src.loid',
        ],
    ],
    'rules'     => [
        '/social/login/service/<service:(google|facebook|vkontakte|twitter|github)>'    => 'social/user/login',
        '/social/connect/service/<service:(google|facebook|vkontakte|twitter|github)>'  => 'social/user/connect',
        '/social/register/service/<service:(google|facebook|vkontakte|twitter|github)>' => 'social/user/register',
    ],
];
