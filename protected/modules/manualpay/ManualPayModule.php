<?php

use yupe\components\WebModule;

class ManualPayModule extends WebModule
{
    const VERSION = '0.9.9';

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
        return Yii::t('ManualPayModule.manual', 'Store');
    }

    public function getName()
    {
        return Yii::t('ManualPayModule.manual', 'Manual payment');
    }

    public function getDescription()
    {
        return Yii::t('ManualPayModule.manual', 'Manual payment module');
    }

    public function getAuthor()
    {
        return Yii::t('ManualPayModule.manual', 'Oleg Filimonov');
    }

    public function getAuthorEmail()
    {
        return Yii::t('ManualPayModule.manual', 'olegsabian@gmail.com');
    }

    public function getIcon()
    {
        return 'fa fa-money';
    }

    public function init()
    {
        parent::init();
    }
}
