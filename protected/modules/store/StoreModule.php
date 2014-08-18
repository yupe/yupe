<?php

use yupe\components\WebModule;

class StoreModule extends WebModule
{
    const VERSION = '0.1';

    public $uploadPath = 'store';
    public $allowedExtensions = 'jpg,jpeg,png,gif';
    public $minSize = 0;
    public $maxSize;
    public $maxFiles = 1;
    public $assetsPath = "application.modules.store.views.assets";

    public function getDependencies()
    {
        return array('comment');
    }

    public function getUploadPath()
    {
        return Yii::getPathOfAlias('webroot') . '/' . Yii::app()->getModule('yupe')->uploadPath . '/' . $this->uploadPath;
    }

    public function checkSelf()
    {
        $messages = array();

        return isset($messages[WebModule::CHECK_ERROR]) ? $messages : true;
    }

    public function getInstall()
    {
        if (parent::getInstall()) {
            @mkdir($this->getUploadPath(), 0755);
        }

        return true;
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
            'uploadPath' => Yii::t('StoreModule.store', 'Каталог для загрузок файлов (относительно Yii::app()->getModule("yupe")->uploadPath)'),
            'editor' => Yii::t('StoreModule.store', 'Визуальный редактор'),
        );
    }

    public function getEditableParamsGroups()
    {
        return array(
            '0.main' => array(
                'label' => Yii::t('StoreModule.store', 'Настройки визуальных редакторов'),
                'items' => array(
                    'uploadPath',
                    'editor'
                )
            ),
        );
    }

    public function getNavigation()
    {
        return false;
    }

    public function getExtendedNavigation()
    {
        return array(
            array(
                'icon' => 'glyphicon glyphicon-shopping-cart',
                'label' => Yii::t('StoreModule.store', 'Каталог'),
                'items' => array(
                    array(
                        'icon' => 'glyphicon glyphicon-folder-open',
                        'label' => Yii::t('StoreModule.storegory', 'Категории'),
                        'url' => array('/store/categoryBackend/index'),
                        'items' => array(
                            array('icon' => 'glyphicon glyphicon-list-alt', 'label' => Yii::t('StoreModule.storegory', 'Список категорий'), 'url' => array('/store/categoryBackend/index')),
                            array('icon' => 'glyphicon glyphicon-plus-sign', 'label' => Yii::t('StoreModule.storegory', 'Добавить категорию'), 'url' => array('/store/categoryBackend/create')),
                        ),
                    ),
                    array(
                        'icon' => 'glyphicon glyphicon-edit',
                        'label' => Yii::t('StoreModule.storeibute', 'Атрибуты'),
                        'url' => array('/store/attributeBackend/index'),
                        'items' => array(
                            array('icon' => 'glyphicon glyphicon-list-alt', 'label' => Yii::t('StoreModule.storeibute', 'Список атрибутов'), 'url' => array('/store/attributeBackend/index')),
                            array('icon' => 'glyphicon glyphicon-plus-sign', 'label' => Yii::t('StoreModule.storeibute', 'Добавить атрибут'), 'url' => array('/store/attributeBackend/create')),
                        ),
                    ),
                    array(
                        'icon' => 'glyphicon glyphicon-list-alt',
                        'label' => Yii::t('StoreModule.store', 'Типы товаров'),
                        'url' => array('/store/typeBackend/index'),
                        'items' => array(
                            array('icon' => 'glyphicon glyphicon-list-alt', 'label' => Yii::t('StoreModule.store', 'Список типов'), 'url' => array('/store/typeBackend/index')),
                            array('icon' => 'glyphicon glyphicon-plus-sign', 'label' => Yii::t('StoreModule.store', 'Добавить тип'), 'url' => array('/store/typeBackend/create')),
                        ),
                    ),
                    array(
                        'icon' => 'glyphicon glyphicon-plane',
                        'label' => Yii::t('StoreModule.store', 'Производители'),
                        'url' => array('/store/producerBackend/index'),
                        'items' => array(
                            array('icon' => 'glyphicon glyphicon-list-alt', 'label' => Yii::t('StoreModule.store', 'Список производителей'), 'url' => array('/store/producerBackend/index')),
                            array('icon' => 'glyphicon glyphicon-plus-sign', 'label' => Yii::t('StoreModule.store', 'Добавить производителя'), 'url' => array('/store/producerBackend/create')),
                        ),
                    ),
                    array(
                        'icon' => 'glyphicon glyphicon-shopping-cart',
                        'label' => Yii::t('StoreModule.store', 'Товары'),
                        'url' => array('/store/productBackend/index'),
                        'items' => array(
                            array('icon' => 'glyphicon glyphicon-list-alt', 'label' => Yii::t('StoreModule.store', 'Список товаров'), 'url' => array('/store/productBackend/index')),
                            array('icon' => 'glyphicon glyphicon-plus-sign', 'label' => Yii::t('StoreModule.store', 'Добавить товар'), 'url' => array('/store/productBackend/create')),
                        ),
                    ),
                ),
            ),
        );
    }

    public function getAdminPageLink()
    {
        //return '/store/orderBackend/index';
        return '/store/productBackend/index';
    }

    public function getVersion()
    {
        return self::VERSION;
    }

    public function getCategory()
    {
        return Yii::t('StoreModule.store', 'Content');
    }

    public function getName()
    {
        return Yii::t('StoreModule.store', 'Магазин');
    }

    public function getDescription()
    {
        return Yii::t('StoreModule.store', 'Модуль для создания расширенного каталога товаров');
    }

    public function getAuthor()
    {
        return Yii::t('StoreModule.store', 'Dark_Cs');
    }

    public function getAuthorEmail()
    {
        return Yii::t('StoreModule.store', 'darkcs2@gmail.com');
    }

    public function getUrl()
    {
        //return Yii::t('StoreModule.store', 'http://migsite.ru');
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
                'store.models.*',
            )
        );
    }

    public function beforeControllerAction($controller, $action)
    {
        $mainAssets = $this->getAssetsUrl();
        if ($controller instanceof \yupe\components\controllers\BackController) {
            Yii::app()->getClientScript()->registerCssFile($mainAssets . '/css/store-backend.css');
        } else {
            Yii::app()->getClientScript()->registerCssFile($mainAssets . '/css/store-frontend.css');
            Yii::app()->getClientScript()->registerScriptFile($mainAssets . '/js/store.js');
        }
        return parent::beforeControllerAction($controller, $action);
    }

    public function getAuthItems()
    {
        return array(
            array(
                'type' => AuthItem::TYPE_ROLE,
                'name' => 'Store.Manager',
                'description' => Yii::t("StoreModule.store", 'Управляющий каталогом товаров'),
                'items' => array(
                    array(
                        'type' => AuthItem::TYPE_TASK,
                        'name' => 'Store.AttributeBackend.Management',
                        'description' => Yii::t("StoreModule.store", 'Управление атрибутами товаров'),
                        'items' => array(
                            array('type' => AuthItem::TYPE_OPERATION, 'name' => 'Store.AttributeBackend.Index', 'description' => Yii::t("StoreModule.store", 'Просмотр списка атрибутов'),),
                            array('type' => AuthItem::TYPE_OPERATION, 'name' => 'Store.AttributeBackend.Create', 'description' => Yii::t("StoreModule.store", 'Создание атрибута'),),
                            array('type' => AuthItem::TYPE_OPERATION, 'name' => 'Store.AttributeBackend.Update', 'description' => Yii::t("StoreModule.store", 'Редактирование атрибута'),),
                            array('type' => AuthItem::TYPE_OPERATION, 'name' => 'Store.AttributeBackend.View', 'description' => Yii::t("StoreModule.store", 'Просмотр атрибута'),),
                            array('type' => AuthItem::TYPE_OPERATION, 'name' => 'Store.AttributeBackend.Delete', 'description' => Yii::t("StoreModule.store", 'Удаление атрибута'),),
                        ),
                    ),
                    array(
                        'type' => AuthItem::TYPE_TASK,
                        'name' => 'Store.CategoryBackend.Management',
                        'description' => Yii::t("StoreModule.store", 'Управление категориями товаров'),
                        'items' => array(
                            array('type' => AuthItem::TYPE_OPERATION, 'name' => 'Store.CategoryBackend.Index', 'description' => Yii::t("StoreModule.store", 'Просмотр списка категорий'),),
                            array('type' => AuthItem::TYPE_OPERATION, 'name' => 'Store.CategoryBackend.Create', 'description' => Yii::t("StoreModule.store", 'Создание категории'),),
                            array('type' => AuthItem::TYPE_OPERATION, 'name' => 'Store.CategoryBackend.Update', 'description' => Yii::t("StoreModule.store", 'Редактирование категории'),),
                            array('type' => AuthItem::TYPE_OPERATION, 'name' => 'Store.CategoryBackend.View', 'description' => Yii::t("StoreModule.store", 'Просмотр категории'),),
                            array('type' => AuthItem::TYPE_OPERATION, 'name' => 'Store.CategoryBackend.Delete', 'description' => Yii::t("StoreModule.store", 'Удаление категории'),),
                        ),
                    ),
                    array(
                        'type' => AuthItem::TYPE_TASK,
                        'name' => 'Store.ProducerBackend.Management',
                        'description' => Yii::t("StoreModule.store", 'Управление производителями'),
                        'items' => array(
                            array('type' => AuthItem::TYPE_OPERATION, 'name' => 'Store.ProducerBackend.Index', 'description' => Yii::t("StoreModule.store", 'Просмотр списка производителей'),),
                            array('type' => AuthItem::TYPE_OPERATION, 'name' => 'Store.ProducerBackend.Create', 'description' => Yii::t("StoreModule.store", 'Создание производителя'),),
                            array('type' => AuthItem::TYPE_OPERATION, 'name' => 'Store.ProducerBackend.Update', 'description' => Yii::t("StoreModule.store", 'Редактирование производителя'),),
                            array('type' => AuthItem::TYPE_OPERATION, 'name' => 'Store.ProducerBackend.View', 'description' => Yii::t("StoreModule.store", 'Просмотр производителя'),),
                            array('type' => AuthItem::TYPE_OPERATION, 'name' => 'Store.ProducerBackend.Delete', 'description' => Yii::t("StoreModule.store", 'Удаление производителя'),),
                        ),
                    ),
                    array(
                        'type' => AuthItem::TYPE_TASK,
                        'name' => 'Store.ProductBackend.Management',
                        'description' => Yii::t("StoreModule.store", 'Управление товарами'),
                        'items' => array(
                            array('type' => AuthItem::TYPE_OPERATION, 'name' => 'Store.ProductBackend.Index', 'description' => Yii::t("StoreModule.store", 'Просмотр списка товаров'),),
                            array('type' => AuthItem::TYPE_OPERATION, 'name' => 'Store.ProductBackend.Create', 'description' => Yii::t("StoreModule.store", 'Создание товара'),),
                            array('type' => AuthItem::TYPE_OPERATION, 'name' => 'Store.ProductBackend.Update', 'description' => Yii::t("StoreModule.store", 'Редактирование товара'),),
                            array('type' => AuthItem::TYPE_OPERATION, 'name' => 'Store.ProductBackend.View', 'description' => Yii::t("StoreModule.store", 'Просмотр товара'),),
                            array('type' => AuthItem::TYPE_OPERATION, 'name' => 'Store.ProductBackend.Delete', 'description' => Yii::t("StoreModule.store", 'Удаление товара'),),
                        ),
                    ),
                    array(
                        'type' => AuthItem::TYPE_TASK,
                        'name' => 'Store.TypeBackend.Management',
                        'description' => Yii::t("StoreModule.store", 'Управление типами товаров'),
                        'items' => array(
                            array('type' => AuthItem::TYPE_OPERATION, 'name' => 'Store.TypeBackend.Index', 'description' => Yii::t("StoreModule.store", 'Просмотр списка типов'),),
                            array('type' => AuthItem::TYPE_OPERATION, 'name' => 'Store.TypeBackend.Create', 'description' => Yii::t("StoreModule.store", 'Создание типа'),),
                            array('type' => AuthItem::TYPE_OPERATION, 'name' => 'Store.TypeBackend.Update', 'description' => Yii::t("StoreModule.store", 'Редактирование типа'),),
                            array('type' => AuthItem::TYPE_OPERATION, 'name' => 'Store.TypeBackend.View', 'description' => Yii::t("StoreModule.store", 'Просмотр типа'),),
                            array('type' => AuthItem::TYPE_OPERATION, 'name' => 'Store.TypeBackend.Delete', 'description' => Yii::t("StoreModule.store", 'Удаление типа'),),
                        ),
                    ),
                ),
            ),
        );
    }
}
