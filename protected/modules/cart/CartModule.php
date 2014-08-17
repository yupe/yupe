<?php

use yupe\components\WebModule;

class CartModule extends WebModule
{
    const VERSION = '0.1';

    public $assetsPath = 'cart.views.assets';

    public function getDependencies()
    {
        return array('order');
    }

    public function getEditableParams()
    {
        return array();
    }

    public function getNavigation()
    {
        return false;
    }

    public function getVersion()
    {
        return self::VERSION;
    }

    public function getName()
    {
        return Yii::t('CartModule.cart', 'Корзина');
    }

    public function getDescription()
    {
        return Yii::t('CartModule.cart', 'Корзина покупок в интернет-магазине');
    }

    public function getAuthor()
    {
        return Yii::t('CartModule.cart', 'Dark_Cs');
    }

    public function getAuthorEmail()
    {
        return Yii::t('CartModule.cart', 'darkcs2@gmail.com');
    }

    public function getCategory()
    {
        return Yii::t('CartModule.cart', 'Store');
    }

    public function getIcon()
    {
        return 'glyphicon glyphicon-shopping-cart';
    }

    public function init()
    {
        parent::init();

        $this->setImport(
            array(
                'cart.extensions.shopping-cart.*',
                'cart.widgets.ShoppingCartWidget',
                'cart.models.*',
            )
        );
    }

    public function clearCart()
    {
        Yii::app()->shoppingCart->clear();
    }

    public function beforeControllerAction($controller, $action)
    {
        $mainAssets = $this->getAssetsUrl();
        if ($controller instanceof \yupe\components\controllers\BackController) {

        } else {
            Yii::app()->getClientScript()->registerCssFile($mainAssets . '/css/cart-frontend.css');
        }
        return parent::beforeControllerAction($controller, $action);
    }

}
