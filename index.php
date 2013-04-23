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
date_default_timezone_set('Europe/Moscow');

// Выбираем конфигурацию development-main.php, если переменная окружения php_env установлена в development
// или мы работаем на локалхосте:
if (defined('YII_DEBUG') || getenv('php_env') == 'development' || strpos($_SERVER['SERVER_ADDR'], '127') === 0) {
    // Комментируем перед выпуском в продакшен:
    define('YII_DEBUG', true);

    // путь к фреймворку Yii
    $yii = dirname(__FILE__) . '/framework/yii.php';

    // путь к основному конфигурационному файлу Yii
    $config = dirname(__FILE__) . '/protected/config/main-development.php';
    defined('YII_DEBUG') or define('YII_DEBUG', true);
    defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL', 3);
} else { //production считается во всех случаях, когда не выполнены условия
    // путь к фреймворку Yii
    $yii = dirname(__FILE__) . '/framework/yiilite.php';
    // путь к основному конфигурационному файлу Yii
    $config = dirname(__FILE__) . '/protected/config/main.php';
}

require $yii;
Yii::createWebApplication($config)->run();