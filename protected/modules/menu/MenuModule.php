<?php

/**
 * MenuModule основной класс модуля menu
 *
 * @author yupe team <team@yupe.ru>
 * @link http://yupe.ru
 * @copyright 2009-2013 amyLabs && Yupe! team
 * @package yupe.modules.menu
 * @since 0.1
 *
 */

class MenuModule extends yupe\components\WebModule
{
    public $defaultController = 'menu';

    public $menuCache         = 'menu.cache';

    public function getIsInstallDefault()
    {
        return true;
    }

    public function getCategory()
    {
        return Yii::t('MenuModule.menu', 'Structure');
    }

    public function getName()
    {
        return Yii::t('MenuModule.menu', 'Menu');
    }

    public function getDescription()
    {
        return Yii::t('MenuModule.menu', 'Menu management module');
    }

    public function getVersion()
    {
        return Yii::t('MenuModule.menu', '0.3');
    }

    public function getAuthor()
    {
        return Yii::t('MenuModule.menu', 'yupe team');
    }

    public function getAuthorEmail()
    {
        return Yii::t('MenuModule.menu', 'team@yupe.ru');
    }

    public function getUrl()
    {
        return Yii::t('MenuModule.menu', 'http://yupe.ru');
    }

    public function getIcon()
    {
        return "list";
    }

    public function getAdminPageLink()
    {
        return '/menu/menuBackend/index';
    }

    public function getNavigation()
    {
        return array(
            array('label' => Yii::t('MenuModule.menu', 'Menu')),
            array('icon' => 'list-alt','label' => Yii::t('MenuModule.menu', 'Manage menu'), 'url' => array('/menu/menuBackend/index')),
            array('icon' => 'plus-sign','label' => Yii::t('MenuModule.menu', 'Create menu'), 'url' => array('/menu/menuBackend/create')),
            array('label' => Yii::t('MenuModule.menu', 'Menu items')),
            array('icon' => 'list-alt','label' => Yii::t('MenuModule.menu', 'Manage menu items'), 'url' => array('/menu/menuitemBackend/index')),
            array('icon' => 'plus-sign','label' => Yii::t('MenuModule.menu', 'Create menu item'), 'url' => array('/menu/menuitemBackend/create')),
        );
    }

    public function init()
    {
        $this->setImport(array(
            'application.modules.menu.models.*'         
        ));
    }
}