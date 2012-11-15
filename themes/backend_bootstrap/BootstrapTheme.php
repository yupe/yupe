<?php
/**
 *  BootstrapTheme
 *
 *  Тема bootstrap, используется приложение Yii-Bootstrap http://www.yiiframework.com/extension/bootstrap/ (1.2.0)
 *  Тема booster, используется приложение YiiBooster http://yii-booster.clevertech.biz/index.html (1.0.3)
 *
 * @author Yupe Team
 * @link   http://yupe.ru
 * @version 1.2.0
 *
 */
 
Yii::app()->setComponent('bootstrap', Yii::createComponent(array(
    'class' => $themeBase . '.extensions.bootstrap.components.Bootstrap',
)));

Yii::setPathOfAlias('bootstrap', Yii::app()->theme->basePath . '/extensions/bootstrap');
Yii::app()->preload[] = 'bootstrap';