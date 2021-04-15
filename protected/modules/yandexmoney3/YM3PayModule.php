<?php

use yupe\components\WebModule;

/**
 * Class YM3PayModule
 */
class YM3PayModule extends WebModule
{
    /**
     *
     */
    const VERSION = '1.0-dev';

    /**
     * @return array
     */
    public function getDependencies()
    {
        return ['payment'];
    }

    /**
     * @return array
     */
    public function getNavigation()
    {
        return [];
    }

    /**
     * @return bool
     */
    public function getAdminPageLink()
    {
        return false;
    }

    /**
     * @return bool
     */
    public function getIsShowInAdminMenu()
    {
        return false;
    }

    /**
     * @return string
     */
    public function getVersion()
    {
        return self::VERSION;
    }

    /**
     * @return array
     */
    public function getEditableParams()
    {
        return [];
    }

    /**
     * @return string
     */
    public function getCategory()
    {
        return Yii::t('YM3PayModule.ymoney', 'Store');
    }

    /**
     * @return string
     */
    public function getName()
    {
        return Yii::t('YM3PayModule.ymoney', 'Yandex.Money API v3');
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return Yii::t('YM3PayModule.ymoney', 'Yandex.Money payment module');
    }

    /**
     * @return string
     */
    public function getAuthor()
    {
        return Yii::t('YM3PayModule.ymoney', 'OMG');
    }

    /**
     * @return string
     */
    public function getAuthorEmail()
    {
        return Yii::t('YM3PayModule.ymoney', 'box@omg.im');
    }

    /**
     * @return string
     */
    public function getIcon()
    {
        return 'fa fa-jpy';
    }

    /**
     *
     */
    public function init()
    {
        parent::init();
    }
}
