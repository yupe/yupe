<?php

use yupe\components\WebModule;

class ShopModule extends WebModule
{
    public $uploadPath = 'shop';
    public $allowedExtensions = 'jpg,jpeg,png,gif';
    public $minSize = 0;
    public $maxSize;
    public $maxFiles = 1;

    public function getDependencies()
    {
        return array('comment');
    }

    public function getUploadPath()
    {
        return Yii::getPathOfAlias('webroot') . '/' .
        Yii::app()->getModule('yupe')->uploadPath . '/' .
        $this->uploadPath;
    }

    public function checkSelf()
    {
        $messages = array();

        return isset($messages[WebModule::CHECK_ERROR]) ? $messages : true;
    }

    public function getInstall()
    {
        if (parent::getInstall())
        {
            @mkdir($this->getUploadPath(), 0755);
        }

        return false;
    }

    public function getEditableParams()
    {
        return array(
            'uploadPath',
            'editor' => Yii::app()->getModule('yupe')->editors,
        );
    }

    public function getParamsLabels()
    {
        return array(
            'uploadPath' => Yii::t('ShopModule.catalog', 'File uploads directory (relative to Yii::app()->getModule("yupe")->uploadPath)'),
            'editor' => Yii::t('ShopModule.catalog', 'Visual editor'),
        );
    }

    public function getNavigation()
    {
        return array();
    }

    public function getExtendedNavigation()
    {
        return array(
            array('icon' => 'icon-shopping-cart',
                'label' => Yii::t('ShopModule.product', 'Каталог'),
                'items' => array(
                    array('icon' => 'folder-open',
                        'label' => Yii::t('ShopModule.category', 'Категории'),
                        'url' => array('/shop/categoryBackend/index'),
                        'items' => array(
                            array('icon' => 'list-alt', 'label' => Yii::t('ShopModule.category', 'Список категорий'), 'url' => array('/shop/categoryBackend/index')),
                            array('icon' => 'plus-sign', 'label' => Yii::t('ShopModule.category', 'Добавить категорию'), 'url' => array('/shop/categoryBackend/create')),
                        ),
                    ),
                    array('icon' => 'edit',
                        'label' => Yii::t('ShopModule.attribute', 'Атрибуты'),
                        'url' => array('/shop/attributeBackend/index'),
                        'items' => array(
                            array('icon' => 'list-alt', 'label' => Yii::t('ShopModule.attribute', 'Список атрибутов'), 'url' => array('/shop/attributeBackend/index')),
                            array('icon' => 'plus-sign', 'label' => Yii::t('ShopModule.attribute', 'Добавить атрибут'), 'url' => array('/shop/attributeBackend/create')),
                        ),
                    ),
                    array('icon' => 'icon-list-alt',
                        'label' => Yii::t('ShopModule.type', 'Типы товаров'),
                        'url' => array('/shop/typeBackend/index'),
                        'items' => array(
                            array('icon' => 'list-alt', 'label' => Yii::t('ShopModule.type', 'Список типов'), 'url' => array('/shop/typeBackend/index')),
                            array('icon' => 'plus-sign', 'label' => Yii::t('ShopModule.type', 'Добавить тип'), 'url' => array('/shop/typeBackend/create')),
                        ),
                    ),
                    array('icon' => 'icon-plane',
                        'label' => Yii::t('ShopModule.producer', 'Производители'),
                        'url' => array('/shop/producerBackend/index'),
                        'items' => array(
                            array('icon' => 'list-alt', 'label' => Yii::t('ShopModule.producer', 'Список производителей'), 'url' => array('/shop/producerBackend/index')),
                            array('icon' => 'plus-sign', 'label' => Yii::t('ShopModule.producer', 'Добавить производителя'), 'url' => array('/shop/producerBackend/create')),
                        ),
                    ),
                    array('icon' => 'icon-shopping-cart',
                        'label' => Yii::t('ShopModule.product', 'Товары'),
                        'url' => array('/shop/productBackend/index'),
                        'items' => array(
                            array('icon' => 'list-alt', 'label' => Yii::t('ShopModule.product', 'Список товаров'), 'url' => array('/shop/productBackend/index')),
                            array('icon' => 'plus-sign', 'label' => Yii::t('ShopModule.product', 'Добавить товар'), 'url' => array('/shop/productBackend/create')),
                        ),
                    )
                )),
            array('icon' => 'icon-shopping-cart',
                'label' => Yii::t('ShopModule.product', 'Настройки'),
                'items' => array(
                    array('icon' => 'icon-plane',
                        'label' => Yii::t('ShopModule.delivery', 'Доставка'),
                        'url' => array('/shop/deliveryBackend/index'),
                        'items' => array(
                            array('icon' => 'list-alt', 'label' => Yii::t('ShopModule.delivery', 'Список способов доставки'), 'url' => array('/shop/deliveryBackend/index')),
                            array('icon' => 'plus-sign', 'label' => Yii::t('ShopModule.delivery', 'Добавить способ'), 'url' => array('/shop/deliveryBackend/create')),
                        ),
                    ),
                    array('icon' => 'icon-shopping-cart',
                        'label' => Yii::t('ShopModule.payment', 'Оплата'),
                        'url' => array('/shop/paymentBackend/index'),
                        'items' => array(
                            array('icon' => 'list-alt', 'label' => Yii::t('ShopModule.payment', 'Список способов оплаты'), 'url' => array('/shop/paymentBackend/index')),
                            array('icon' => 'plus-sign', 'label' => Yii::t('ShopModule.payment', 'Добавить способ'), 'url' => array('/shop/paymentBackend/create')),
                        ),
                    ),
                    array('icon' => 'icon-tags',
                        'label' => Yii::t('ShopModule.coupon', 'Купоны'),
                        'url' => array('/shop/couponBackend/index'),
                        'items' => array(
                            array('icon' => 'list-alt', 'label' => Yii::t('ShopModule.coupon', 'Список купонов'), 'url' => array('/shop/couponBackend/index')),
                            array('icon' => 'plus-sign', 'label' => Yii::t('ShopModule.coupon', 'Добавить купон'), 'url' => array('/shop/couponBackend/create')),
                        ),
                    ),
                )),
            array('icon' => 'icon-gift', 'label' => Yii::t('ShopModule.order', 'Заказы'), 'url' => array('/shop/orderBackend/index')),
        );
    }

    public function getAdminPageLink()
    {
        return '/shop/shopBackend/index';
    }

    public function getVersion()
    {
        return '0.1';
    }

    public function getCategory()
    {

    }

    public function getName()
    {
        return Yii::t('ShopModule.shop', 'Интернет-магазин');
    }

    public function getDescription()
    {
        return Yii::t('ShopModule.shop', 'Модуль для организации простого интернет-магазина');
    }

    public function getAuthor()
    {
        return Yii::t('ShopModule.shop', 'Dark_Cs');
    }

    public function getAuthorEmail()
    {
        return Yii::t('ShopModule.shop', 'darkcs2@gmail.com');
    }

    public function getUrl()
    {
        //return Yii::t('ShopModule.catalog', 'http://yupe.ru');
    }

    public function getIcon()
    {
        return 'shopping-cart';
    }

    public function init()
    {
        parent::init();

        $this->setImport(array(
            'shop.models.*',
            'shop.extensions.shopping-cart.*',
            'shop.widgets.ShoppingCartWidget',
            'shop.components.payments.*',
        ));
    }

    public function beforeControllerAction($controller, $action)
    {
        $mainAssets = Yii::app()->assetManager->publish(Yii::getPathOfAlias('application.modules.shop.views.assets'), false, -1, YII_DEBUG);
        if (strpos($controller->id, 'Backend'))
        {
            Yii::app()->clientScript->registerCssFile($mainAssets . '/css/shop.css');
        }
        else
        {
            Yii::app()->clientScript->registerCssFile($mainAssets . '/css/shop-front.css');
            Yii::app()->clientScript->registerScriptFile($mainAssets . '/js/shop.js');
        }
        return parent::beforeControllerAction($controller, $action);
    }
}