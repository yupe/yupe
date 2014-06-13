<?php

/**
 * Файл основных настроек приложения
 *
 * ВНИМАНИЕ! ДАННЫЙ ФАЙЛ ИСПОЛЬЗУЕТСЯ ЯДРОМ YUPE!
 * ИЗМЕНЕНИЯ В ДАННОМ ФАЙЛЕ МОГУТ ПРИВЕСТИ К ПОТЕРЕ РАБОТОСПОСОБНОСТИ
 * Для собственных настроек создайте и используйте "/protected/config/userspace.php"
 * Подробную информацию по использованию "userspace" можно узнать из официальной
 * документаци - http://yupe.ru/docs/yupe/userspace.config.html
 *
 * @category YupeConfig
 * @package  Yupe
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @version  0.6
 * @link     http://yupe.ru
 *
 **/

// Определяем алиасы:
Yii::setPathOfAlias('application', dirname(__FILE__) . '/../');
Yii::setPathOfAlias('public', dirname($_SERVER['SCRIPT_FILENAME']));
Yii::setPathOfAlias('yupe', dirname(__FILE__) . '/../modules/yupe/');
Yii::setPathOfAlias('vendor', dirname(__FILE__) . '/../../vendor/');

return array(
	'basePath'				=> dirname(__FILE__) . '/..',
	'defaultController'		=> 'site',// Контроллер по умолчанию
	'name'					=> 'Yupe!',// Название приложения
	'language'				=> 'ru',// Язык по умолчанию
	'sourceLanguage'		=> 'en',
	'theme'					=> 'default',// Тема оформления по умолчанию
	'charset'				=> 'UTF-8',
	'controllerNamespace'	=> 'application\controllers',

	'preload' => defined('YII_DEBUG') && YII_DEBUG && is_writable(Yii::getPathOfAlias('application.runtime')) && is_writable(Yii::getPathOfAlias('public.assets')) ? array('debug') : array(),

	'aliases' => array(
		'bootstrap' => realpath(Yii::getPathOfAlias('vendor') . '/clevertech/yii-booster/src'),
	),

	// -- Пути для поиска и импорта классов
	'import' => array(
		'application.components.Dump',
		'application.components.TpDbConnection',
		'application.components.TpModel',

		'application.modules.yupe.models.*',
		'application.modules.yupe.widgets.*',
		'application.modules.yupe.controllers.*',
		'application.modules.yupe.extensions.tagcache.*',
	),
	// -- -- -- --

	// -- Подключение и конфигурирование модулей (Подробнее: http://www.yiiframework.ru/doc/guide/ru/basics.module)
	'modules' => array(

		'install' => array(
			'class' => 'application.modules.install.InstallModule',
		),

		'yupe'  => array(
			'class'        => 'application.modules.yupe.YupeModule',
			'cache'        => true,
		),

		// -- На продакшне gii рекомендуется отключить, подробнее: http://www.yiiframework.com/doc/guide/1.1/en/quickstart.first-app
		/*
		'gii' => array(
			'class'				=> 'system.gii.GiiModule',
			'password'			=> 'giiYupe',
			'ipFilters'			=> array(),
			'generatorPaths'	=> array(
				'application.modules.yupe.extensions.yupe.gii',
			),
		),
		*/
		// -- -- -- --
	),
	// -- -- -- --

	'behaviors' => array(
		'onBeginRequest' => array(
			'class' => 'yupe\components\urlManager\LanguageBehavior'
		 ),
	),

	'params' => require dirname(__FILE__) . '/params.php',

	// Конфигурирование основных компонентов (подробнее http://www.yiiframework.ru/doc/guide/ru/basics.component)

	'components' => array(
		// -- Вывод отладочной информации
		'debug' => array(
			'class'			=> 'vendor.zhuravljov.yii2-debug.Yii2Debug',
			'allowedIPs'	=> array(
				'10.60.5.102',
				'10.0.2.2',
				'10.0.2.15',
				'127.0.0.1',
			),
		),
		// -- -- -- --

		// -- Параметры подключения к базе данных (Подробнее http://www.yiiframework.ru/doc/guide/ru/database.overview)
		'db' => file_exists(__DIR__ . '/db.php') ? require_once __DIR__ . '/db.php' : array(),
		// -- -- -- --

		'bootstrap' => array(
			'class' => 'bootstrap.components.Bootstrap',
			'responsiveCss'  => true,
			'fontAwesomeCss' => true,
		),

		'configManager' => array(
				'class' => 'yupe\components\ConfigManager',
		),

		'moduleManager' => array(
			'class' => 'yupe\components\ModuleManager',
		),

		// -- Работа с миграциями, обновление БД модулей
		'migrator' => array(
			'class' => 'yupe\components\Migrator',
		),
		// -- -- -- --

		// -- DAO simple wrapper:
		'dao' => array(
			'class' => 'yupe\components\DAO',
		),
		// -- -- -- --

		'image' => array(
			'class' => 'application\modules\yupe\components\image\Image',
		),

		'uploadManager' => array(
			'class' => 'application\modules\yupe\components\UploadManager',
		),

		'themeManager' => array(
			'basePath' => dirname(__DIR__) . '/../themes',
		),

		// конфигурирование urlManager, подробнее: http://www.yiiframework.ru/doc/guide/ru/topics.url
		'urlManager' => array(
			'class'				=> 'yupe\components\urlManager\LangUrlManager',
			'languageInPath'	=> true,
			'langParam'			=> 'language',
			'urlFormat'			=> 'path',
			'showScriptName'	=> false, // чтобы убрать index.php из url, читаем: http://yiiframework.ru/doc/guide/ru/quickstart.apache-nginx-config
			'cacheID'			=> 'cache',
			'useStrictParsing'	=> true,
			'rules'				=> array(
				'/'																=> 'install/default/index',// общие правила
				'/install/default/<action:\w+>'									=> '/install/default/<action>',// для корректной работы устновщика
				'/backend'														=> 'yupe/backend/index',
				'/backend/<action:\w+>'											=> 'yupe/backend/<action>',
				'/backend/<module:\w+>/<controller:\w+>'						=> '<module>/<controller>Backend/index',
				'/backend/<module:\w+>/<controller:\w+>/<action:\w+>/<id:\d+>'	=> '<module>/<controller>Backend/<action>',
				'/backend/<module:\w+>/<controller:\w+>/<action:\w+>'			=> '<module>/<controller>Backend/<action>',
				'/gii/<controller:\w+>/<action:\w+>'							=> 'gii/<controller>/<action>',
				'/site/<action:\w+>'											=> 'site/<action>',
				'/debug/<controller:\w+>/<action:\w+>'                          => 'debug/<controller>/<action>', // Для  YiiDebugPanel
			)
		),

		// конфигурируем компонент CHttpRequest для защиты от CSRF атак, подробнее: http://www.yiiframework.ru/doc/guide/ru/topics.security
		// РЕКОМЕНДУЕМ УКАЗАТЬ СВОЕ ЗНАЧЕНИЕ ДЛЯ ПАРАМЕТРА "csrfTokenName"
		// базовый класс CHttpRequest переопределен для загрузки файлов через ajax, подробнее: http://www.yiiframework.com/forum/index.php/topic/8689-disable-csrf-verification-per-controller-action/
		'request' => array(
			'class'						=> 'yupe\components\HttpRequest',
			'enableCsrfValidation'		=> true,
			'enableCookieValidation'	=> true,
			'csrfTokenName'				=> 'MY_TOKEN',
			'noCsrfValidationRoutes'	=> array('backend/image/image/AjaxImageUpload', 'backend/image/image/AjaxImageUpload'),
			'csrfCookie'				=> array(
				'httpOnly' => true,
			),
		),

		'session' => array(
			'cookieParams' => array(
				'httponly' => true,
			),
			'autoStart'=>true,				
		),

		// -- Подключение компонента для генерации ajax-ответов
		'ajax' => array(
			'class' => 'yupe\components\AsyncResponse',
		),
		// -- -- -- --

		// -- Настройки кэширования (Подробнее http://www.yiiframework.ru/doc/guide/ru/caching.overview)
		'cache' => array(
			'class' => 'CFileCache',
			'behaviors' => array(
				'clear' => array(
					'class' => 'application.modules.yupe.extensions.tagcache.TaggingCacheBehavior',
				),
			),
		),

		// -- Параметры логирования, подробнее http://www.yiiframework.ru/doc/guide/ru/topics.logging
		'log' => array(
			'class'		=> 'CLogRouter',
			'routes'	=> array(
				array(
					//'class'		=> 'CFileLogRoute',
					'class'         => 'CDbLogRoute',
					'connectionID'  => 'db',
					'autoCreateLogTable' => true,
                    'logTableName'       => 'yii_log',
					'levels'	=> 'error, warning',// на продакшн лучше оставить error, warning
				),
			),
		),
		// -- -- -- --

		// -- Подключение компонента подсветки кода highlight.js (Подробнее: http://softwaremaniacs.org/soft/highlight/)
		'highlightjs' => array(
			'class'		=> 'application.modules.yupe.extensions.highlightjs.Highlightjs',
			'remote'	=> false,
			'style'		=>'github',
		),
		// -- -- -- --

		'errorHandler'=>array(
			'errorAction'=>'site/error',// use 'site/error' action to display errors
		),
	),

	// -- Подробнее http://yupe.ru/docs/yupe/userspace.config.html
	'rules' => array(
		//
	)
	// -- -- -- --
);

