<?php

// основной конфигурационный файл Yii и Юпи! (подробнее http://www.yiiframework.ru/doc/guide/ru/basics.application)
return array(
    'basePath'          => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    // контроллер по умолчанию
    'defaultController' => 'site',
    // название приложения
    'name'              => 'Юпи!',
    // язык по умолчанию
    'language'          => 'ru',
    
    'sourceLanguage'    => 'ru',
    // тема оформления по умолчанию
    'theme'             => 'default',
    // preloading 'log' component
    'preload'           => array( 'log' ),
    // подключение путей
    'import'            => array(
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
        'application.modules.blog.models.*',
        'application.modules.menu.models.*',
        'application.modules.yupe.controllers.*',
        'application.modules.yupe.widgets.*',
        'application.modules.yupe.helpers.*',
        'application.modules.yupe.models.*',
        'application.modules.feedback.models.*',
        'application.modules.category.models.*',
        'application.modules.yupe.components.*',
        'application.modules.yupe.components.exceptions.*',
        'application.modules.queue.components.*',
        'application.modules.queue.models.*',
        'application.modules.social.widgets.ysc.*',
        'application.modules.social.components.*',
        'application.modules.social.models.*',
        'application.modules.social.extensions.eoauth.*',
        'application.modules.social.extensions.eoauth.lib.*',
        'application.modules.social.extensions.lightopenid.*',
        'application.modules.social.extensions.eauth.services.*',
    ),
    // конфигурирование основных компонентов (подробнее http://www.yiiframework.ru/doc/guide/ru/basics.component)
    'components' => array(
/*
        // Если используется модуль geo  - надо как-то интегрировать в сам модуль
        'sxgeo' => array(
            'class' => 'application.modules.geo.extensions.sxgeo.CSxGeoIP',
            'filename' => dirname(__FILE__)."/../modules/geo/data/SxGeoCity.dat",
        ),
*/
        'queue' => array(
            'class'          => 'application.modules.queue.components.YDbQueue',
            'connectionId'   => 'db',
            'workerNamesMap' => array(
                1 => 'Отправка почты',
                2 => 'Ресайз изображений',
            )
        ),
        // Библиотека для работы с картинками через GD/ImageMagick
        // Лучше установите ImageMagick, т.к. он ресайзит анимированные гифы
        'image' => array(
            'class'  => 'application.modules.yupe.extensions.image.CImageComponent',
            'driver' => 'GD', // Еще бывает ImageMagick, если используется он, надо указать к нему путь чуть ниже
            'params' => array( 'directory' => '/usr/bin' ), // В этой директории должен быть convert
        ),
        // подключение библиотеки для авторизации через социальные сервисы, подробнее https://github.com/Nodge/yii-eauth
        'loid' => array(
            'class' => 'application.modules.social.extensions.lightopenid.loid',
        ),
        // экстеншн для авторизации через социальные сети подробнее http://habrahabr.ru/post/129804/
        'eauth' => array(
            'class'    => 'application.modules.social.extensions.eauth.EAuth',
            'popup'    => true, // Use the popup window instead of redirecting.
            'services' => array( // You can change the providers and their classes.
                'google' => array('class' => 'CustomGoogleService'),
                'yandex' => array('class' => 'CustomYandexService'),
            ),
        ),
        // компонент для отправки почты
        'mail' => array(
            'class' => 'application.modules.mail.components.YMail',
        ),
        'mailMessage' => array(
            'class' => 'application.modules.mail.components.YMailMessage'
        ),
        // конфигурирование urlManager, подробнее http://www.yiiframework.ru/doc/guide/ru/topics.url
        'urlManager' => array(
            'class'=>'application.modules.yupe.extensions.urlManager.LangUrlManager',
            'urlFormat' => 'path',
            // для того чтобы убрать index.php из url, читаем статью http://yiiframework.ru/doc/guide/ru/quickstart.apache-nginx-config
            'showScriptName' => true,
            'cacheID'        => 'cache',
            'rules'          => array(
                '/'                                                     => 'site/index',
                '/login'                                                => 'user/account/login',
                '/logout'                                               => 'user/account/logout',
                '/registration'                                         => 'user/account/registration',
                '/recovery'                                             => 'user/account/recovery',
                '/feedback'                                             => 'feedback/feedback',
                '/pages/<slug>'                                         => 'page/page/show',
                '/story/<title>'                                        => 'news/news/show/',
                '/post/<slug>.html'                                     => 'blog/post/show/',
                '/posts/tag/<tag>'                                      => 'blog/post/list/',
                '/blog/<slug>'                                          => 'blog/blog/show/',
                '/blogs/'                                               => 'blog/blog/index/',
                '/users/'                                               => 'user/people/index/',
                '/profile/'                                             => 'user/people/profile/',
                '/install'                                              => 'install/default/index/',
                '/wiki/<controller:\w+>/<action:\w+>'                   => '/yeeki/wiki/<controller>/<action>',
                '/site/page/<view:\w+>'                                 => 'site/page/view/<view>',
                '/yupe/backend/modulesettings/<module:\w+>'             => '/yupe/backend/modulesettings/',
                'user/<username:\w+>/'                                  => 'user/people/userInfo',
                '<module:\w+>/<controller:\w+>/<action:\w+>/<id:\d+>'   => '<module>/<controller>/<action>',
                '<module:\w+>/<controller:\w+>/<action:\w+>'            => '<module>/<controller>/<action>',
                '<module:\w+>/<controller:\w+>'                         => '<module>/<controller>/index',
                '<controller:\w+>/<action:\w+>'                         => '<controller>/<action>',
                '<controller:\w+>'                                      => '<controller>/index',
            ),
        ),
        // конфигурируем компонент CHttpRequest для защиты от CSRF атак, подробнее http://www.yiiframework.ru/doc/guide/ru/topics.security
        // РЕКОМЕНДУЕМ УКАЗАТЬ СВОЕ ЗНАЧЕНИЕ ДЛЯ ПАРАМЕТРА "csrfTokenName"
        // Базовый класс CHttpRequest переопределен для загрузки файлов через ajax, подробнее http://www.yiiframework.com/forum/index.php/topic/8689-disable-csrf-verification-per-controller-action/
        'request' => array(
            'class'                  => 'YHttpRequest',
            'enableCsrfValidation'   => true,
            'csrfTokenName'          => 'YUPE_TOKEN',
            'noCsrfValidationRoutes' => array('yupe/backend/AjaxFileUpload'),
        ),
        // подключение компонента для генерации ajax-ответов
        'ajax' => array(
            'class' => 'application.modules.yupe.components.YAsyncResponse',
        ),
        // компонент Yii::app()->user, подробнее http://www.yiiframework.ru/doc/guide/ru/topics.auth
        'user' => array(
            'class'    => 'application.modules.user.components.YWebUser',
            'loginUrl' => '/user/account/login/'
        ),
        // параметры подключения к базе данных, подробнее http://www.yiiframework.ru/doc/guide/ru/database.overview
        'db' => require(dirname(__FILE__) . '/db.php'),
        // настройки кэширования, подробнее http://www.yiiframework.ru/doc/guide/ru/caching.overview
        'cache' => array(
            'class' => 'CFileCache',
        ),
        // параметры логирования, подробнее http://www.yiiframework.ru/doc/guide/ru/topics.logging
        'log' => array(
            'class'  => 'CLogRouter',
            'routes' => array(
                array(
                    'class'  => 'CFileLogRoute',
                    'levels' => 'error, warning, info',
                ),
                //профайлер запросов к базе данных, на продакшн серверах рекомендуется отключить
                array(
                    'class'        => 'application.modules.yupe.extensions.db_profiler.DbProfileLogRoute',
                    'countLimit'   => 1, // How many times the same query should be executed to be considered inefficient
                    'slowQueryMin' => 0.01, // Minimum time for the query to be slow
                ),
            ),
        ),
    ),
    // конфигурация модулей приложения, подробнее http://www.yiiframework.ru/doc/guide/ru/basics.module
    'modules' => require(dirname(__FILE__) . '/modules.php'),

    'behaviors' => array(
        'onBeginRequest' => array('class' => 'application.modules.yupe.extensions.urlManager.LanguageBehavior'),
        'YupeStartUpBehavior',
    ),
);
