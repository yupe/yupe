<?php
return array(
    'module' => array(
        'class' => 'application.modules.social.SocialModule',
    ),
    'import' => array(
        'application.modules.social.components.*',
        'application.modules.social.components.services.*',
        'application.modules.social.models.*',
        'application.modules.social.extensions.eauth.services.*',
        'application.modules.social.extensions.eauth.*',
        'application.modules.social.extensions.eoauth.lib.*',
        'application.modules.social.extensions.eoauth.*'
    ),
    'component' => array(
        'eauth' => array(
            'class' => 'application.modules.social.extensions.eauth.EAuth',
            'popup' => false,
            'services' => array(
                'google' => array(
                    'class' => 'Google',
                    'requiredAttributes' => array(
                        'email' => array('email', 'contact/email'),
                    ),
                ),
//                'google-oauth' => array(
//                    // register your app here: https://code.google.com/apis/console/
//                    'class' => 'GoogleOAuthService',
//                    'client_id' => '',
//                    'client_secret' => '',
//                    'title' => 'Google (OAuth2)',
//                ),
//                'yandex' => array(
//                    'class' => 'YandexOpenIDService',
//                    'title' => 'Yandex',
//                ),
//                'yandex-oauth' => array(
//                    // register your app here: https://oauth.yandex.ru/client/my
//                    'class' => 'YandexOAuthService',
//                    'client_id' => '',
//                    'client_secret' => '',
//                    'title' => 'Yandex (OAuth)',
//                ),
//                'twitter' => array(
//                    // register your app here: https://dev.twitter.com/apps/new
//                    'class' => 'TwitterOAuthService',
//                    'key' => '',
//                    'secret' => '',
//                ),
//                'linkedin' => array(
//                    // register your app here: https://www.linkedin.com/secure/developer
//                    'class' => 'LinkedinOAuthService',
//                    'key' => '',
//                    'secret' => '',
//                ),
//                'facebook' => array(
//                    // register your app here: https://developers.facebook.com/apps/
//                    'class' => 'Facebook',
//                    'client_id' => '',
//                    'client_secret' => '',
//                    'scope' => array('email'),
//                ),
//                'live' => array(
//                    // register your app here: https://manage.dev.live.com/Applications/Index
//                    'class' => 'LiveOAuthService',
//                    'client_id' => '',
//                    'client_secret' => '',
//                ),
//                'vkontakte' => array(
//                    // register your app here: https://vk.com/editapp?act=create&site=1
//                    'class' => 'VKontakteOAuthService',
//                    'client_id' => '',
//                    'client_secret' => '',
//                    'title' => 'VKontakte',
//                ),
//                'mailru' => array(
//                    // register your app here: http://api.mail.ru/sites/my/add
//                    'class' => 'MailruOAuthService',
//                    'client_id' => '',
//                    'client_secret' => '',
//                ),
//                'moikrug' => array(
//                    // register your app here: https://oauth.yandex.ru/client/my
//                    'class' => 'MoikrugOAuthService',
//                    'client_id' => '',
//                    'client_secret' => '',
//                    //'title' => 'Moi Krug',
//                ),
//                'github' => array(
//                    // register your app here: https://github.com/settings/applications
//                    'class' => 'GitHubOAuthService',
//                    'client_id' => '',
//                    'client_secret' => '',
//                ),
//                'odnoklassniki' => array(
//                    // register your app here: http://www.odnoklassniki.ru/dk?st.cmd=appsInfoMyDevList&st._aid=Apps_Info_MyDev
//                    'class' => 'OdnoklassnikiOAuthService',
//                    'client_id' => '...',
//                    'client_public' => '...',
//                    'client_secret' => '...',
//                    'title' => 'Odnokl.',
//                ),
            ),
        ),
        'loid' => array(
            'class' => 'application.modules.social.extensions.lightopenid.loid',
        ),
    ),
    'rules' => array(
        '/social/login/service/<service:(google)>' => 'social/user/login',
        '/social/connect/service/<service:(google)>' => 'social/user/connect',
        '/social/register/service/<service:(google)>' => 'social/user/register',
    ),
);