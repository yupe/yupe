<?php

$yii = dirname(__FILE__) . '/../../vendor/yiisoft/yii/framework/yii.php';
require_once $yii;

$config = require_once dirname(__FILE__) . '/../../protected/config/console.php';

if(!Yii::app())
    Yii::createConsoleApplication($config);