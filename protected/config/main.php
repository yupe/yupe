<?php
// основной конфигурационный файл Yii и Юпи! (подробнее http://www.yiiframework.ru/doc/guide/ru/basics.application)
return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'defaultController' => 'site',
    // название приложения
    'name' => 'Юпи!',
    // язык поумолчанию
    'language' => 'ru',
    // тема оформления поумолчанию
    'theme' => 'default',
    // preloading 'log' component
    'preload' => array('log'),

    // подключение путей
    'import' => array(        
        'application.components.*',   
             
        // подключение путей из основных модулей 
        'application.modules.user.UserModule',
        'application.modules.user.models.*',
        'application.modules.user.forms.*',
        'application.modules.user.components.*',                

        'application.modules.page.models.*',

        'application.modules.news.models.*',
        'application.modules.contentblock.models.*',
        'application.modules.comment.models.*',
        'application.modules.image.models.*',
        'application.modules.vote.models.*',

        'application.modules.yupe.controllers.*', 
        'application.modules.yupe.widgets.*',        
        'application.modules.yupe.helpers.*',
        'application.modules.yupe.models.*',        
        'application.modules.yupe.components.*',                

        'application.modules.social.widgets.ysc.*',

        'application.modules.social.components.*',      
        'application.modules.social.extensions.eoauth.*',
        'application.modules.social.extensions.eoauth.lib.*',
        'application.modules.social.extensions.lightopenid.*',
        'application.modules.social.extensions.eauth.services.*',
    ),

    // конфигурирование основных компонентов (подробнее http://www.yiiframework.ru/doc/guide/ru/basics.component)
    'components' => array(

        'loid' => array(
            'class' => 'application.modules.social.extensions.lightopenid.loid',
        ),

        'eauth' => array(
            'class' => 'application.modules.social.extensions.eauth.EAuth',
            'popup' => true, // Use the popup window instead of redirecting.
            'services' => array( // You can change the providers and their classes.
                'google' => array(
                  'class' => 'GoogleOpenIDService',
                ),
                'yandex' => array(
                   'class' => 'YandexOpenIDService',
                ),
            )
        ),

        'yupe' => array(
            'class' => 'application.modules.yupe.components.Yupe'
        ),

        // компонент для отправки почты
        'mail' => array(
            'class' => 'application.modules.yupe.components.YMail'
        ),
        
        // конфигурирование urlManager (подробнее http://www.yiiframework.ru/doc/guide/ru/topics.url)
        'urlManager' => array(
            'urlFormat' => 'path',
            'showScriptName' => true,
            'cacheID' => 'cache',
            'rules' => array(
                '/login' => 'user/account/login',
                '/logout' => 'user/account/logout',
                '/registration' => 'user/account/registration',
                '/feedback' => 'feedback/feedback',
                '/pages/<slug>' => 'page/page/show',
                '/story/<title>' => 'news/news/show/'
            ),
        ),
         
        // конфигурируем компонент CHttpRequest для защиты от CSRF атак (подробнее http://www.yiiframework.ru/doc/guide/ru/topics.security)
        // РЕКОМЕНДУЕМ УКАЗАТЬ СВОЕ ЗНАЧЕНИЕ ДЛЯ ПАРАМЕТРА "csrfTokenName"
        'request' => array(
            'class' => 'CHttpRequest',
            'enableCsrfValidation' => true,
            'csrfTokenName' => 'YUPE_TOKEN'
        ),

        'ajax' => array(
            'class' => 'application.modules.yupe.components.YAsyncResponse'
        ),

        'user' => array(
            'class' => 'application.modules.user.components.YWebUser',
            'loginUrl' => '/user/account/login/'
        ),

        'db' => require(dirname(__FILE__) . '/db.php'),

        'cache' => array(
            'class' => 'CFileCache'
        ),

        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(                
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error, warning, info',
                ),                
                array(
                    'class'=>'application.modules.yupe.extensions.db_profiler.DbProfileLogRoute',
                    'countLimit' => 1, // How many times the same query should be executed to be considered inefficient
                    'slowQueryMin' => 0.01, // Minimum time for the query to be slow
                ),                
            ),
        ),
    ),

    'modules' => array(
        'social' => array(
            'class' => 'application.modules.social.SocialModule',
        ),
        'comment' => array(
            'class' => 'application.modules.comment.CommentModule',
            'defaultCommentStatus' => 0
        ),
        'dictionary' => array(
            'class' => 'application.modules.dictionary.DictionaryModule',
        ),
        'gallery' => array(
            'class' => 'application.modules.gallery.GalleryModule',
        ),
        'vote' => array(
            'class' => 'application.modules.vote.VoteModule',
        ),
        'contest' => array(
            'class' => 'application.modules.contest.ContestModule',
        ),
        'image' => array(
            'class' => 'application.modules.image.ImageModule',
        ),
        'yupe' => array(
            'class' => 'application.modules.yupe.YupeModule',
            'brandUrl' => 'http://yupe.ru?from=engine'
        ),
        'install' => array(
            'class' => 'application.modules.install.InstallModule',            
        ),
        'category' => array(
            'class' => 'application.modules.category.CategoryModule',
            'adminMenuOrder' => 5,            
        ),
        'news' => array(
            'class' => 'application.modules.news.NewsModule',
            'adminMenuOrder' => 1,            
        ),
        'user' => array(
            'class' => 'application.modules.user.UserModule',
            'adminMenuOrder' => 4,
            'autoRecoveryPassword' => true,
            'minPasswordLength' => 3,
            'maxPasswordLength' => 6,
            'emailAccountVerification' => false,
            'showCaptcha' => true,
            'minCaptchaLength' => 3,
            'maxCaptchaLength' => 5,
            'documentRoot' => $_SERVER['DOCUMENT_ROOT'],
            'avatarsDir' => '/yupe/avatars',
            'avatarMaxSize' => 100000,
            'avatarExtensions' => array('jpg', 'png', 'gif'),
            'notifyEmailFrom' => 'aopeykin@yandex.ru',
        ),
        'page' => array(
            'adminMenuOrder' => 2,
            'class' => 'application.modules.page.PageModule',
            'layout' => 'application.views.layouts.column2'
        ),
        'contentblock' => array(
            'class' => 'application.modules.contentblock.ContentBlockModule',
        ),
        'feedback' => array(
            'class' => 'application.modules.feedback.FeedbackModule',
            'adminMenuOrder' => 3,
            'types' => array(
                1 => 'Ошибка на сайте',
                2 => 'Предложение о сотрудничестве',
                3 => 'Прочее..'
            ),
            'showCaptcha' => true,
            'notifyEmailFrom' => 'aopeykin@yandex.ru',
            'backEnd' => array('email', 'db'),
            'emails' => array('opeykin@mail.ru', 'aopeykin@google.com'),
            'enabled' => true
        ),
        'gii' => array(
            'class' => 'system.gii.GiiModule',
            'password' => 'giiYupe'
        ),
    ),    
);
