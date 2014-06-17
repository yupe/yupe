<?php

define('YII_APP_TYPE', 'console');

require dirname(__FILE__).'/../vendor/autoload.php';

// change the following paths if necessary
$yiic = require dirname(__FILE__) . '/../vendor/yiisoft/yii/framework/yii.php';
$base = require dirname(__FILE__) . '/config/console.php';

$confManager = new yupe\components\ConfigManager();
$config = $confManager->merge($base);

$app=Yii::createConsoleApplication($config);
$app->commandRunner->addCommands(YII_PATH.'/cli/commands');
$app->run();



