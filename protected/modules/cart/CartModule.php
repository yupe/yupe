<?php

use yupe\components\WebModule;

class CartModule extends WebModule
{
    const VERSION = '0.9';

    public $assetsPath = 'cart.views.assets';

    public function getDependencies()
    {
        return ['order'];
    }

    public function getEditableParams()
    {
        return [];
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

    public function getName()
    {
        return Yii::t('CartModule.cart', 'Cart');
    }

    public function getDescription()
    {
        return Yii::t('CartModule.cart', 'Shopping cart in online store');
    }

    public function getAuthor()
    {
        return Yii::t('CartModule.cart', 'amylabs team');
    }

    public function getAuthorEmail()
    {
        return Yii::t('CartModule.cart', 'hello@amylabs.ru');
    }

    public function getAuthorUrl()
    {
        return Yii::t('CartModule.cart', 'http://amylabs.ru');
    }

    public function getCategory()
    {
        return Yii::t('CartModule.cart', 'Store');
    }

    public function getIcon()
    {
        return 'fa fa-fw fa-shopping-cart';
    }

    public function init()
    {
        parent::init();

        $this->setImport(
            [
                'cart.extensions.shopping-cart.*',
                'cart.widgets.ShoppingCartWidget',
                'cart.models.*',
            ]
        );
    }

    public function clearCart()
    {
        Yii::app()->cart->clear();
    }
}
