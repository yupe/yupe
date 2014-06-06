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
        return array();
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
            //'mainCategory' => CHtml::listData($this->getCategoryList(), 'id', 'name'),
            'uploadPath',
            //'adminMenuOrder',
            'editor'       => Yii::app()->getModule('yupe')->editors,
            //'allowedExtensions',
            //'minSize',
            //'maxSize',
        );
    }

    public function getParamsLabels()
    {
        return array(
            //'mainCategory'      => Yii::t('ShopModule.catalog', 'Main category of products'),
            //'adminMenuOrder'    => Yii::t('ShopModule.catalog', 'Menu items order'),
            'uploadPath'        => Yii::t('ShopModule.catalog', 'File uploads directory (relative to Yii::app()->getModule("yupe")->uploadPath)'),
            'editor'            => Yii::t('ShopModule.catalog', 'Visual editor'),
            //'allowedExtensions' => Yii::t('ShopModule.catalog', 'Accepted extensions (separated by comma)'),
            //'minSize'           => Yii::t('ShopModule.catalog', 'Minimum size (in bytes)'),
            //'maxSize'           => Yii::t('ShopModule.catalog', 'Maximum size (in bytes)'),
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
                array('icon'  => 'folder-open',
                    'label' => Yii::t('ShopModule.category', 'Категории'),
                    'url'   => array('/shop/categoryBackend/index'),
                    'items' => array(
                        array('icon' => 'list-alt', 'label' => Yii::t('ShopModule.category', 'Список категорий'), 'url' => array('/shop/categoryBackend/index')),
                        array('icon' => 'plus-sign', 'label' => Yii::t('ShopModule.category', 'Добавить категорию'), 'url' => array('/shop/categoryBackend/create')),
                    ),
                ),
                array('icon'  => 'edit',
                    'label' => Yii::t('ShopModule.attribute', 'Атрибуты'),
                    'url'   => array('/shop/attributeBackend/index'),
                    'items' => array(
                        array('icon' => 'list-alt', 'label' => Yii::t('ShopModule.attribute', 'Список атрибутов'), 'url' => array('/shop/attributeBackend/index')),
                        array('icon' => 'plus-sign', 'label' => Yii::t('ShopModule.attribute', 'Добавить атрибут'), 'url' => array('/shop/attributeBackend/create')),
                    ),
                ),
                array('icon'  => 'icon-list-alt',
                    'label' => Yii::t('ShopModule.type', 'Типы товаров'),
                    'url'   => array('/shop/typeBackend/index'),
                    'items' => array(
                        array('icon' => 'list-alt', 'label' => Yii::t('ShopModule.type', 'Список типов'), 'url' => array('/shop/typeBackend/index')),
                        array('icon' => 'plus-sign', 'label' => Yii::t('ShopModule.type', 'Добавить тип'), 'url' => array('/shop/typeBackend/create')),
                    ),
                ),
                array('icon'  => 'icon-plane',
                    'label' => Yii::t('ShopModule.producer', 'Производители'),
                    'url'   => array('/shop/producerBackend/index'),
                    'items' => array(
                        array('icon' => 'list-alt', 'label' => Yii::t('ShopModule.producer', 'Список производителей'), 'url' => array('/shop/producerBackend/index')),
                        array('icon' => 'plus-sign', 'label' => Yii::t('ShopModule.producer', 'Добавить производителя'), 'url' => array('/shop/producerBackend/create')),
                    ),
                ),
                array('icon'  => 'icon-shopping-cart',
                    'label' => Yii::t('ShopModule.product', 'Товары'),
                    'url'   => array('/shop/productBackend/index'),
                    'items' => array(
                        array('icon' => 'list-alt', 'label' => Yii::t('ShopModule.product', 'Список товаров'), 'url' => array('/shop/productBackend/index')),
                        array('icon' => 'plus-sign', 'label' => Yii::t('ShopModule.product', 'Добавить товар'), 'url' => array('/shop/productBackend/create')),
                    ),
                )
                //array('icon' => 'list-alt', 'label' => Yii::t('ShopModule.catalog', 'Product list'), 'url' => array('/catalog/catalogBackend/index')),
                //array('icon' => 'plus-sign', 'label' => Yii::t('ShopModule.catalog', 'Add a product'), 'url' => array('/catalog/catalogBackend/create')),
            )),
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
        ));
    }
}