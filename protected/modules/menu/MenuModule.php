<?php
class MenuModule extends YWebModule
{
    public $defaultController = 'menu';
    public $menuCache         = 'menu.cache';

    public function getCategory()
    {
        return Yii::t('menu', 'Структура');
    }

    public function getName()
    {
        return Yii::t('menu', 'Меню');
    }

    public function getDescription()
    {
        return Yii::t('menu', 'Модуль для создания и редактирования меню');
    }

    public function getVersion()
    {
        return Yii::t('menu', '0.3 (dev)');
    }

    public function getAuthor()
    {
        return Yii::t('menu', 'yupe team');
    }

    public function getAuthorEmail()
    {
        return Yii::t('menu', 'team@yupe.ru');
    }

    public function getUrl()
    {
        return Yii::t('menu', 'http://yupe.ru');
    }

    public function getIcon()
    {
        return "list";
    }

    public function getNavigation()
    {
        return array(
            array('label' => Yii::t('menu', 'Меню')),
            array('icon' => 'plus-sign','label' => Yii::t('menu', 'Добавить меню'), 'url' => array('/menu/menu/create')),
            array('icon' => 'list-alt','label' => Yii::t('menu', 'Управление меню'), 'url' => array('/menu/menu/index')),
            array('label' => Yii::t('menu', 'Пункты меню')),
            array('icon' => 'plus-sign','label' => Yii::t('menu', 'Добавить пункт меню'), 'url' => array('/menu/menuitem/create')),
            array('icon' => 'list-alt','label' => Yii::t('menu', 'Упрвление пунктами меню'), 'url' => array('/menu/menuitem/index')),
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