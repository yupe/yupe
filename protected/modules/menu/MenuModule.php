<?php
class MenuModule extends YWebModule
{
    public $defaultController = 'menu';
    public $menuCache         = 'menu.cache';

    public function getIsInstallDefault()
    {
        return true;
    }

    public function getCategory()
    {
        return Yii::t('MenuModule.menu', 'Структура');
    }

    public function getName()
    {
        return Yii::t('MenuModule.menu', 'Меню');
    }

    public function getDescription()
    {
        return Yii::t('MenuModule.menu', 'Модуль для создания и редактирования меню');
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

    public function getNavigation()
    {
        return array(
            array('label' => Yii::t('MenuModule.menu', 'Меню')),
            array('icon' => 'list-alt','label' => Yii::t('MenuModule.menu', 'Управление меню'), 'url' => array('/menu/menu/index')),
            array('icon' => 'plus-sign','label' => Yii::t('MenuModule.menu', 'Добавить меню'), 'url' => array('/menu/menu/create')),
            array('label' => Yii::t('MenuModule.menu', 'Пункты меню')),
            array('icon' => 'list-alt','label' => Yii::t('MenuModule.menu', 'Управление пунктами меню'), 'url' => array('/menu/menuitem/index')),
            array('icon' => 'plus-sign','label' => Yii::t('MenuModule.menu', 'Добавить пункт меню'), 'url' => array('/menu/menuitem/create')),
        );
    }

    public function init()
    {
        $this->setImport(array(
            'application.modules.menu.models.*',
            'application.modules.menu.components.*',
        ));
    }
}