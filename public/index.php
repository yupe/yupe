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

// Setting internal encoding to UTF-8.
if(!ini_get('mbstring.internal_encoding')) {
    @ini_set("mbstring.internal_encoding", 'UTF-8');
    mb_internal_encoding('UTF-8');
}

define('YII_APP_TYPE', 'web');

// две строки закомментировать на продакшн сервере
define('YII_DEBUG', true);
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL', 3);

require dirname(__FILE__) . '/../vendor/yiisoft/yii/framework/yii.php';

$base = require dirname(__FILE__) . '/../protected/config/main.php';

$confManager = new yupe\components\ConfigManager();
$config = $confManager->merge($base);

require dirname(__FILE__).'/../vendor/autoload.php';

Yii::createWebApplication($config)->run();
