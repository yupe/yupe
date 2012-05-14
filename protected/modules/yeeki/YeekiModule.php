<?php
/**
 * Yeeki module.
 *
 * Includes all necessary wiki functionality. Can be used as a module in your
 * application.
 */
class YeekiModule extends YWebModule
{
    public function getCategory()
    {
        return Yii::t('menu', 'Контент');
    }

    public function getNavigation()
    {
        return array(
            //Yii::t('menu', 'Wiki')=>'/wiki/default/admin/',
        );
    }

    public function getName()
    {
        return Yii::t('menu', 'Wiki');
    }

    public function getDescription()
    {
        return Yii::t('menu', 'Модуль для создания и редактирования меню');
    }

    public function getVersion()
    {
        return Yii::t('comment', '1.0');
    }

    public function getAuthor()
    {
        return Yii::t('menu', 'Alexander Makarov, @samdark. Mark Bryk, @mbryk.');
    }

    public function getAuthorEmail()
    {
        return Yii::t('menu', 'sam@rmcreative.ru');
    }

    public function getUrl()
    {
        return Yii::t('menu', 'https://github.com/samdark/Yeeki');
    }

    public function init()
    {
        parent::init();
        $this->setImport(array(
            'yeeki.components.*',
            'application.modules.yeeki.modules.wiki.WikiModule',
            'application.modules.yeeki.modules.wiki.controllers.*',
            'application.modules.yeeki.modules.wiki.models.*',
            'application.modules.yeeki.modules.wiki.*',
            'application.modules.yeeki.modules.wiki.components.*',
        ));
    }

}
