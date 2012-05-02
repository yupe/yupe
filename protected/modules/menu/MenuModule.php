<?php
class MenuModule extends YWebModule
{

    public function getCategory()
    {
        return Yii::t('menu', 'Структура');
    }

    public function getNavigation()
    {
        return array(
            Yii::t('menu', 'Меню')=>'/menu/menu/admin/',
        );
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
        return Yii::t('menu', '0.2 (dev)');
    }

    public function getAuthor()
    {
        return Yii::t('menu', 'yupe team');
    }

    public function getAuthorEmail()
    {
        return Yii::t('menu', 'developers@yupe.ru');
    }

    public function getUrl()
    {
        return Yii::t('menu', 'http://yupe.ru');
    }

    public function init()
    {
        $this->setImport(array(
            'menu.models.*',
            'menu.components.*',
        ));
    }
}
