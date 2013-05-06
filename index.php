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

// путь к фреймворку Yii
$yii = dirname(__FILE__) . '/framework/yii.php';
// путь к основному конфигурационному файлу Yii
$config = dirname(__FILE__) . '/protected/config/main.php';

require $yii;
Yii::createWebApplication($config)->run();