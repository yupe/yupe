<?php
require dirname(__FILE__) . '/../vendor/autoload.php';
$yiic = require dirname(__FILE__) . '/../vendor/yiisoft/yii/framework/yii.php';

$config = require dirname(__FILE__) . '/config/console.php';
$configManager = new yupe\components\ConfigManager();
$configManager->sentEnv(\yupe\components\ConfigManager::ENV_CONSOLE);

$app = \Yii::createConsoleApplication($configManager->merge($config));
$app->commandRunner->addCommands(YII_PATH . '/cli/commands');
$app->run();
