<?php

use yupe\components\WebModule;

class YandexMoneyModule extends WebModule
{
    const VERSION = '0.9.7';

    public function getDependencies()
    {
        return ['payment'];
    }

    public function getNavigation()
    {
        return false;
    }

    public function getAdminPageLink()
    {
        return false;
    }

    public function getIsShowInAdminMenu()
    {
        return false;
    }

    public function getVersion()
    {
        return self::VERSION;
    }

    public function getEditableParams()
    {
        return [];
    }

    public function getCategory()
    {
        return Yii::t('YandexMoneyModule.ymoney', 'Store');
    }

    public function getName()
    {
        return Yii::t('YandexMoneyModule.ymoney', 'Yandex.Money');
    }

    public function getDescription()
    {
        return Yii::t('YandexMoneyModule.ymoney', 'Yandex.Money payment module');
    }

    public function getAuthor()
    {
        return Yii::t('YandexMoneyModule.ymoney', 'Dark_Cs');
    }

    public function getAuthorEmail()
    {
        return Yii::t('YandexMoneyModule.ymoney', 'darkcs2@gmail.com');
    }

    public function getIcon()
    {
        return 'fa fa-jpy';
    }

    public function init()
    {
        parent::init();
    }
}
