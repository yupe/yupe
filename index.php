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

// Выбираем конфигурацию development-main.php, если сайт работает на localhost
if (strpos($_SERVER['SERVER_ADDR'], '127') === 0) {
    // Комментируем перед выпуском в продакшен:
    define('YII_DEBUG', true);
    defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL', 3);

    // путь к фреймворку Yii
    $yii = dirname(__FILE__) . '/framework/yii.php';

    // путь к основному конфигурационному файлу Yii
    $userspace = require_once dirname(__FILE__) . '/protected/config/userspace-development.php';

} else { //production считается во всех случаях, когда не выполнены условия
    // путь к фреймворку Yii, при необходимости заменить на yii.php
    $yii = dirname(__FILE__) . '/framework/yiilite.php';
    // путь к основному конфигурационному файлу Yii
    $userspace = require_once dirname(__FILE__) . '/protected/config/userspace.php';
}

$base = require_once dirname(__FILE__) . '/protected/config/main.php';

require $yii;

Yii::setPathOfAlias('application', dirname(__FILE__) . '/protected/');
Yii::setPathOfAlias('yupe', dirname(__FILE__) . '/protected/');
Yii::setPathOfAlias('yii', dirname(__FILE__) . '/framework/');

<<<<<<< HEAD
$confManager = new yupe\modules\yupe\components\ConfigManager();
=======
use \Yii;
use \CMap;
use application\modules\yupe\components\ConfigManager;

$confManager = new ConfigManager();
>>>>>>> parent of 1fad711... Замечания по userspace. Убран userspace.php
$config = $confManager->merge($base, $userspace);

Yii::createWebApplication($config)->run();