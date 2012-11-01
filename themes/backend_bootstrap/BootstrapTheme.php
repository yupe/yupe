<?php
/**
 *  BootstrapTheme
 *
 *  Тема bootstrap, используется приложение Yii-Bootstrap http://www.yiiframework.com/extension/bootstrap/
 *
 * @author Yupe Team
 * @link   http://yupe.ru
 * @version 1.1.0
 *
 */
 
Yii::app()->setComponent('bootstrap', Yii::createComponent(array(
    'class' => $themeBase . '.extensions.bootstrap.components.Bootstrap',
)));

Yii::setPathOfAlias('bootstrap', Yii::app()->theme->basePath . '/extensions/bootstrap');
Yii::app()->preload[] = 'bootstrap';