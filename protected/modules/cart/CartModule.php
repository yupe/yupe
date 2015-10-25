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
    const VERSION = '0.9.9';

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
     * @return bool
     */
    public function getNavigation()
    {
        return false;
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
        return Yii::t('CartModule.cart', 'amylabs team');
    }

    /**
     * @return string
     */
    public function getAuthorEmail()
    {
        return Yii::t('CartModule.cart', 'hello@amylabs.ru');
    }

    /**
     * @return string
     */
    public function getAuthorUrl()
    {
        return Yii::t('CartModule.cart', 'http://amylabs.ru');
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

    /**
     *
     */
    public function init()
    {
        parent::init();

        $this->setImport(
            [
                'cart.components.shopping-cart.*',
                'cart.widgets.ShoppingCartWidget',
                'cart.models.*',
            ]
        );
    }

    /**
     *
     */
    public function clearCart()
    {
        Yii::app()->cart->clear();
    }
}
