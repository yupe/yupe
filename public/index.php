<?php
/**
 * Входной скрипт index:
 * 
 *   @category YupeScript
 *   @package  YupeCMS
 *   @author   Yupe Team <team@yupe.ru>
 *   @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 *   @link     http://yupe.ru
 **/

// подробнее про index.php http://www.yiiframework.ru/doc/guide/ru/basics.entry
if (!ini_get('date.timezone'))
    date_default_timezone_set('UTC');

defined('APP_START') or define('APP_START', microtime(true));

$development = isset($_SERVER['SERVER_ADDR'])
        ? strpos($_SERVER['SERVER_ADDR'], '127') === 0
        : $_SERVER['SERVER_NAME'] == 'localhost';

// Выбираем конфигурацию development-main.php, если сайт работает на localhost
if ($development) {
    // Комментируем перед выпуском в продакшен:
    define('YII_DEBUG', true);
    defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL', 3);
    // В режиме разработки - отключаем кеширование настроек:
    defined('CACHE_SETTINGS') or define('CACHE_SETTINGS', false);
    // путь к фреймворку Yii
    $yii = dirname(__FILE__) . '/../vendor/framework/yii.php';

} else { //production считается во всех случаях, когда не выполнены условия
    // путь к фреймворку Yii, при необходимости заменить на yii.php
    $yii = dirname(__FILE__) . '/../vendor/framework/yiilite.php';
    // путь к основному конфигурационному файлу Yii
}

require $yii;

// Определяем алиасы:
Yii::setPathOfAlias('application', dirname(__FILE__) . '/../protected/');
Yii::setPathOfAlias('yii', dirname(__FILE__) . '/../framework/');
Yii::setPathOfAlias('yupe', dirname(__FILE__) . '/../protected/modules/yupe/');
Yii::setPathOfAlias('vendor', dirname(__FILE__) . '/../vendor/');

$base = require_once dirname(__FILE__) . '/../protected/config/main.php';

$userspace = dirname(__FILE__) . '/../protected/config/userspace.php';
$userspace = file_exists($userspace) ? (require_once $userspace) : array();


$confManager = new yupe\components\ConfigManager();
$config = $confManager->merge($base, $userspace);
//die('<pre>' . print_r($config, true));
Yii::createWebApplication($config)->run();