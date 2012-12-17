<?php
defined('YII_DEBUG') or define('YII_DEBUG', true);

// подключаем файл инициализации Yii
require_once('framework/yii.php');

// файл конфигурации будет отдельный
$configFile = 'protected/config/console.php';

// создаем и запускаем экземпляр приложения
Yii::createConsoleApplication($configFile)->run();
?>
