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
if (!ini_get('date.timezone')) {
    date_default_timezone_set('Europe/Moscow');
}

$development = isset($_SERVER['SERVER_ADDR'])
        ? strpos($_SERVER['SERVER_ADDR'], '127') === 0
        : $_SERVER['SERVER_NAME'] == 'localhost';

// Выбираем конфигурацию development-main.php, если сайт работает на localhost
if ($development || defined('APPLICATION_ENV') || getenv('APPLICATION_ENV') !== false) {
    // Комментируем перед выпуском в продакшен:
    // в режиме разработки необходимо демонстрировать все ошибки
    // независимо от среды
    ini_set('display_errors', 'On');
    define('YII_DEBUG', true);
    defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL', 3);  
    // путь к фреймворку Yii
    $yii = dirname(__FILE__) . '/../vendor/yiisoft/yii/framework/yii.php';

} else { //production считается во всех случаях, когда не выполнены условия
    // путь к фреймворку Yii, при необходимости заменить на yii.php
    $yii = dirname(__FILE__) . '/../vendor/yiisoft/yii/framework/yiilite.php';
    // путь к основному конфигурационному файлу Yii
}

require $yii;

$base = require dirname(__FILE__) . '/../protected/config/main.php';

$userspace = dirname(__FILE__) . '/../protected/config/userspace.php';
$userspace = file_exists($userspace) ? (require $userspace) : array();

$confManager = new yupe\components\ConfigManager();
$config = $confManager->merge($base, $userspace);


require dirname(__FILE__).'/../vendor/autoload.php';

Yii::createWebApplication($config)->run();