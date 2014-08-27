<?php
define('YII_APP_TYPE', 'console');
require dirname(__FILE__) . '/../vendor/autoload.php';
$yiic = require dirname(__FILE__) . '/../vendor/yiisoft/yii/framework/yii.php';

$configManager = new yupe\components\ConfigManager();
$config = require dirname(__FILE__) . '/config/console.php';

$app = Yii::createConsoleApplication($configManager->merge($config));
$app->commandRunner->addCommands(YII_PATH . '/cli/commands');
$app->run();