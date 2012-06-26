<?php
// основной конфигурационный файл Yii и Юпи! (подробнее http://www.yiiframework.ru/doc/guide/ru/basics.application)
return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    // контроллер по умолчанию
    'defaultController' => 'site',
    // название приложения
    'name' => 'Юпи!',
    // язык по умолчанию
    'language' => 'ru',
    // тема оформления по умолчанию
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
        'application.modules.blog.models.*',
        'application.modules.menu.models.*',

        'application.modules.yupe.controllers.*',
        'application.modules.yupe.widgets.*',
        'application.modules.yupe.helpers.*',
        'application.modules.yupe.models.*',
        'application.modules.yupe.components.*',

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
        // Библиотека для работы с картинками через GD/ImageMagick
        // Лучше установите ImageMagick, т.к. он ресайзит анимированные гифы
        'image' => array(
            'class' => 'application.modules.yupe.extensions.image.CImageComponent',
            'driver' => 'GD', // Еще бывает ImageMagick, если используется он, надо указать к нему путь чуть ниже
            'params' => array('directory' => '/usr/bin'), // В этой директории должен быть convert
        ),

        // подключение библиотеки для авторизации через социальные сервисы, подробнее https://github.com/Nodge/yii-eauth
        'loid' => array(
            'class' => 'application.modules.social.extensions.lightopenid.loid',
        ),

        // экстеншн для авторизации через социальные сети подробнее http://habrahabr.ru/post/129804/
        'eauth' => array(
            'class' => 'application.modules.social.extensions.eauth.EAuth',
            'popup' => true, // Use the popup window instead of redirecting.
            'services' => array( // You can change the providers and their classes.
                'google' => array(
                  'class' => 'CustomGoogleService',
                ),
                'yandex' => array(
                   'class' => 'CustomYandexService',
                ),
            ),
        ),

        // компонент для отправки почты
        'mail' => array(
            'class' => 'application.modules.yupe.components.YMail',
        ),

        // конфигурирование urlManager, подробнее http://www.yiiframework.ru/doc/guide/ru/topics.url
        'urlManager' => array(
            'urlFormat' => 'path',
            // для того чтобы убрать index.php из url, читаем статью http://yiiframework.ru/doc/guide/ru/quickstart.apache-nginx-config
            'showScriptName' => true,
            'cacheID' => 'cache',
            'rules' => array(
                '/' => 'site/index',
                '/login' => 'user/account/login',
                '/logout' => 'user/account/logout',
                '/registration' => 'user/account/registration',
                '/feedback' => 'feedback/feedback',
                '/pages/<slug>' => 'page/page/show',
                '/story/<title>' => 'news/news/show/',
                '/post/<slug>.html' => 'blog/post/show/',
                '/posts/tag/<tag>' => 'blog/post/list/',
                '/blog/<slug>' => 'blog/blog/show/',
                '/blogs/' => 'blog/blog/index/',
                '/users/' => 'user/people/index/',
                '/profile/' => 'user/people/profile/',
                '/wiki/<controller:\w+>/<action:\w+>' => '/yeeki/wiki/<controller>/<action>',
                'user/<username:\w+>/' => 'user/people/userInfo',
            ),
        ),

        // конфигурируем компонент CHttpRequest для защиты от CSRF атак, подробнее http://www.yiiframework.ru/doc/guide/ru/topics.security
        // РЕКОМЕНДУЕМ УКАЗАТЬ СВОЕ ЗНАЧЕНИЕ ДЛЯ ПАРАМЕТРА "csrfTokenName"
        // Базовый класс CHttpRequest переопределен для загрузки файлов через ajax, подробнее http://www.yiiframework.com/forum/index.php/topic/8689-disable-csrf-verification-per-controller-action/
        'request' => array(
            'class' => 'YHttpRequest',
            'enableCsrfValidation' => true,
            'csrfTokenName' => 'YUPE_TOKEN',
            'noCsrfValidationRoutes' => array('yupe/backend/AjaxFileUpload')
        ),

        // подключение компонента для генерации ajax-ответов
        'ajax' => array(
            'class' => 'application.modules.yupe.components.YAsyncResponse',
        ),

        // компонент Yii::app()->user, подробнее http://www.yiiframework.ru/doc/guide/ru/topics.auth
        'user' => array(
            'class' => 'application.modules.user.components.YWebUser',
            'loginUrl' => '/user/account/login/'
        ),

         // параметры подключения к базе данных, подробнее http://www.yiiframework.ru/doc/guide/ru/database.overview
        'db' => require(dirname(__FILE__) . '/db.php'),

        // настройки кэширования, подробнее http://www.yiiframework.ru/doc/guide/ru/caching.overview
        'cache' => array(
            'class' => 'CFileCache',
        ),

        'messages' => array(
            'class' => 'CDbMessageSource',
            'language' => 'ru',
            'sourceMessageTable' => 'source_message',
            'translatedMessageTable' => 'message'
            // config for db message source here, see http://www.yiiframework.com/doc/api/CDbMessageSource
        ),

        // параметры логирования, подробнее http://www.yiiframework.ru/doc/guide/ru/topics.logging
       'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error, warning, info',
                ),
                //профайлер запросов к базе данных, на продакшн серверах рекомендуется отключить
                array(
                    'class'=>'application.modules.yupe.extensions.db_profiler.DbProfileLogRoute',
                    'countLimit' => 1, // How many times the same query should be executed to be considered inefficient
                    'slowQueryMin' => 0.01, // Minimum time for the query to be slow
                ),
            ),
        ),
    ),

    // конфигурация модулей приложения, подробнее http://www.yiiframework.ru/doc/guide/ru/basics.module
    'modules' => array(
        'menu' => array(
             'class' => 'application.modules.menu.MenuModule',
         ),
        'blog' => array(
            'class' => 'application.modules.blog.BlogModule',
        ),
        'social' => array(
            'class' => 'application.modules.social.SocialModule',
        ),
        'comment' => array(
            'class' => 'application.modules.comment.CommentModule',
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
            'brandUrl' => 'http://yupe.ru?from=engine',
        ),
        'install' => array(
            'class' => 'application.modules.install.InstallModule',
        ),
        'category' => array(
            'class' => 'application.modules.category.CategoryModule',
        ),
        'news' => array(
            'class' => 'application.modules.news.NewsModule',
        ),
        'user' => array(
            'class' => 'application.modules.user.UserModule',
            'documentRoot' => $_SERVER['DOCUMENT_ROOT'],
            'avatarsDir' => '/yupe/avatars',
            'avatarExtensions' => array('jpg', 'png', 'gif'),
            'notifyEmailFrom' => 'test@test.ru',
            'urlRules' => array(
              'user/people/<username:\w+>/<mode:(topics|comments)>' => 'user/people/userInfo',
              'user/people/<username:\w+>' => 'user/people/userInfo',
              'user/people/' => 'user/people/index',
            ),
        ),
        'page' => array(
            'class' => 'application.modules.page.PageModule',
            'layout' => 'application.views.layouts.column2',
        ),
        'contentblock' => array(
            'class' => 'application.modules.contentblock.ContentBlockModule',
        ),
        'translation' => array(
            'class' => 'application.modules.translation.TranslationModule',
        ),
        'feedback' => array(
            'class' => 'application.modules.feedback.FeedbackModule',
            'notifyEmailFrom' => 'test@test.ru',
            'emails'  => 'test_1@test.ru, test_2@test.ru',
        ),
        'yeeki' => array(
            'class' => 'application.modules.yeeki.YeekiModule',
            'modules'=>array(
                'wiki' => array(
                    'userAdapter' => array('class' => 'WikiUser'),
                ),
            ),
            /*
            'controllerMap' => array(
                'default' => array(
                    'class' => 'application.modules.yeeki.modules.wiki.controllers.DefaultController',
                ),
            ),*/
        ),
        // подключение gii в режиме боевой работы рекомендуется отключить (подробнее http://www.yiiframework.com/doc/guide/1.1/en/quickstart.first-app)
        'gii' => array(
            'class' => 'system.gii.GiiModule',
            'password' => 'giiYupe',
        ),
    ),

    'behaviors' => array('YupeStartUpBehavior'),
);
