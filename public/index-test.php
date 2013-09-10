<?php
/**
 * This is the bootstrap file for test application.
 * This file should be removed when the application is deployed for production.
 */

// change the following paths if necessary
$yii = dirname(__FILE__) . '/../vendor/framework/yii.php';
$config = dirname(__FILE__) . '/../protected/config/test.php';

if(!isset($_SERVER['HTTP_ACCEPT'])) {
    $_SERVER['HTTP_ACCEPT'] = true;
}

sleep(2);

// remove the following line when in production mode
defined('YII_DEBUG') or define('YII_DEBUG', true);

require_once($yii);
Yii::createWebApplication($config)->run();
