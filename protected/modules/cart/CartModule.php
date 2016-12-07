<?php

use yupe\components\WebModule;

/**
 * Class CartModule
 */
class CartModule extends WebModule
{
    /**
     *
     */
    const VERSION = '1.1';

    /**
     * @var string
     */
    public $assetsPath = 'cart.views.assets';

    /**
     * @return array
     */
    public function getDependencies()
    {
        return ['order', 'coupon'];
    }

    /**
     * @return array
     */
    public function getEditableParams()
    {
        return [];
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
     * @return string
     */
    public function getName()
    {
        return Yii::t('CartModule.cart', 'Cart');
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return Yii::t('CartModule.cart', 'Shopping cart in online store');
    }

    /**
     * @return string
     */
    public function getAuthor()
    {
        return Yii::t('CartModule.cart', 'yupe team');
    }

    /**
     * @return string
     */
    public function getAuthorEmail()
    {
        return Yii::t('CartModule.cart', 'support@yupe.ru');
    }

    /**
     * @return string
     */
    public function getAuthorUrl()
    {
        return Yii::t('CartModule.cart', 'https://yupe.ru');
    }

    /**
     * @return string
     */
    public function getCategory()
    {
        return Yii::t('CartModule.cart', 'Store');
    }

    /**
     * @return string
     */
    public function getIcon()
    {
        return 'fa fa-fw fa-shopping-cart';
    }
}