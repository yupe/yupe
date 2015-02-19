<?php

use yupe\components\WebModule;

class StoreModule extends WebModule
{
    const VERSION = '0.9.4';

    public $uploadPath = 'store';
    public $allowedExtensions = 'jpg,jpeg,png,gif';
    public $minSize = 0;
    public $maxSize;
    public $maxFiles = 1;
    public $assetsPath = "application.modules.store.views.assets";

    public function getDependencies()
    {
        return ['comment'];
    }

    public function getUploadPath()
    {
        return Yii::getPathOfAlias('webroot') . '/' . Yii::app()->getModule('yupe')->uploadPath . '/' . $this->uploadPath;
    }

    public function checkSelf()
    {
        $messages = [];

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
        return [
            'uploadPath',
            'editor'    => Yii::app()->getModule('yupe')->editors
        ];
    }

    public function getParamsLabels()
    {
        return [
            'uploadPath' => Yii::t('StoreModule.store', 'File uploads directory (relative to Yii::app()->getModule("yupe")->uploadPath)'),
            'editor'     => Yii::t('StoreModule.store', 'Visual editor')
        ];
    }

    public function getEditableParamsGroups()
    {
        return [
            '0.main' => [
                'label' => Yii::t('StoreModule.store', 'Visual editor settings'),
                'items' => [
                    'uploadPath',
                    'editor'
                ]
            ],
        ];
    }

    public function getNavigation()
    {
        return false;
    }

    public function getIsShowInAdminMenu()
    {
        return false;
    }

    public function getExtendedNavigation()
    {
        return [
            [
                'icon'  => 'fa fa-fw fa-shopping-cart',
                'label' => Yii::t('StoreModule.store', 'Catalog'),
                'items' => [
                    [
                        'icon'  => 'fa fa-fw fa-shopping-cart',
                        'label' => Yii::t('StoreModule.product', 'Products'),
                        'url'   => ['/store/productBackend/index'],
                        'items' => [
                            ['icon' => 'fa fa-fw fa-list-alt', 'label' => Yii::t('StoreModule.product', 'Product list'), 'url' => ['/store/productBackend/index']],
                            ['icon' => 'fa fa-fw fa-plus-square', 'label' => Yii::t('StoreModule.product', 'Add a product'), 'url' => ['/store/productBackend/create']],
                        ],
                    ],
                    [
                        'icon'  => 'fa fa-fw fa-list-alt',
                        'label' => Yii::t('StoreModule.type', 'Types'),
                        'url'   => ['/store/typeBackend/index'],
                        'items' => [
                            ['icon' => 'fa fa-fw fa-list-alt', 'label' => Yii::t('StoreModule.type', 'Types list'), 'url' => ['/store/typeBackend/index']],
                            ['icon' => 'fa fa-fw fa-plus-square', 'label' => Yii::t('StoreModule.type', 'Create type'), 'url' => ['/store/typeBackend/create']],
                        ],
                    ],
                    [
                        'icon'  => 'fa fa-fw fa-pencil-square-o',
                        'label' => Yii::t('StoreModule.attr', 'Attributes'),
                        'url'   => ['/store/attributeBackend/index'],
                        'items' => [
                            ['icon' => 'fa fa-fw fa-list-alt', 'label' => Yii::t('StoreModule.attr', 'Attributes list'), 'url' => ['/store/attributeBackend/index']],
                            ['icon' => 'fa fa-fw fa-plus-square', 'label' => Yii::t('StoreModule.attr', 'Create attribute'), 'url' => ['/store/attributeBackend/create']],
                        ],
                    ],
                    [
                        'icon'  => 'fa fa-fw fa-folder-open',
                        'label' => Yii::t('StoreModule.store', 'Categories'),
                        'url'   => ['/store/categoryBackend/index'],
                        'items' => [
                            ['icon' => 'fa fa-fw fa-list-alt', 'label' => Yii::t('StoreModule.store', 'Categories list'), 'url' => ['/store/categoryBackend/index']],
                            ['icon' => 'fa fa-fw fa-plus-square', 'label' => Yii::t('StoreModule.store', 'Create category'), 'url' => ['/store/categoryBackend/create']],
                        ],
                    ],
                    [
                        'icon'  => 'fa fa-fw fa-plane',
                        'label' => Yii::t('StoreModule.store', 'Producers'),
                        'url'   => ['/store/producerBackend/index'],
                        'items' => [
                            ['icon' => 'fa fa-fw fa-list-alt', 'label' => Yii::t('StoreModule.store', 'Producers list'), 'url' => ['/store/producerBackend/index']],
                            ['icon' => 'fa fa-fw fa-plus-square', 'label' => Yii::t('StoreModule.store', 'Create producer'), 'url' => ['/store/producerBackend/create']],
                        ],
                    ],
                ],
            ],
        ];
    }

    public function getAdminPageLink()
    {
        return '/store/storeBackend/index';
    }

    public function getVersion()
    {
        return self::VERSION;
    }

    public function getName()
    {
        return Yii::t('StoreModule.store', 'Store');
    }

    public function getDescription()
    {
        return Yii::t('StoreModule.store', 'Store module');
    }

    public function getAuthor()
    {
        return Yii::t('StoreModule.store', 'amylabs team');
    }

    public function getAuthorEmail()
    {
        return Yii::t('StoreModule.store', 'hello@amylabs.ru');
    }

    public function getUrl()
    {
        return 'http://amylabs.ru';
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
                'application.modules.store.models.*',
                'application.modules.store.forms.*',
                'application.modules.store.components.*',
            ]
        );
    }

    public function getAuthItems()
    {
        return [
            [
                'type'        => AuthItem::TYPE_ROLE,
                'name'        => 'Store.Manager',
                'description' => Yii::t("StoreModule.store", 'Управляющий каталогом товаров'),
                'items'       => [
                    [
                        'type'        => AuthItem::TYPE_TASK,
                        'name'        => 'Store.AttributeBackend.Management',
                        'description' => Yii::t("StoreModule.store", 'Управление атрибутами товаров'),
                        'items'       => [
                            ['type' => AuthItem::TYPE_OPERATION, 'name' => 'Store.AttributeBackend.Index', 'description' => Yii::t("StoreModule.store", 'Просмотр списка атрибутов'),],
                            ['type' => AuthItem::TYPE_OPERATION, 'name' => 'Store.AttributeBackend.Create', 'description' => Yii::t("StoreModule.store", 'Создание атрибута'),],
                            ['type' => AuthItem::TYPE_OPERATION, 'name' => 'Store.AttributeBackend.Update', 'description' => Yii::t("StoreModule.store", 'Редактирование атрибута'),],
                            ['type' => AuthItem::TYPE_OPERATION, 'name' => 'Store.AttributeBackend.View', 'description' => Yii::t("StoreModule.store", 'Просмотр атрибута'),],
                            ['type' => AuthItem::TYPE_OPERATION, 'name' => 'Store.AttributeBackend.Delete', 'description' => Yii::t("StoreModule.store", 'Удаление атрибута'),],
                        ],
                    ],
                    [
                        'type'        => AuthItem::TYPE_TASK,
                        'name'        => 'Store.CategoryBackend.Management',
                        'description' => Yii::t("StoreModule.store", 'Управление категориями товаров'),
                        'items'       => [
                            ['type' => AuthItem::TYPE_OPERATION, 'name' => 'Store.CategoryBackend.Index', 'description' => Yii::t("StoreModule.store", 'Просмотр списка категорий'),],
                            ['type' => AuthItem::TYPE_OPERATION, 'name' => 'Store.CategoryBackend.Create', 'description' => Yii::t("StoreModule.store", 'Создание категории'),],
                            ['type' => AuthItem::TYPE_OPERATION, 'name' => 'Store.CategoryBackend.Update', 'description' => Yii::t("StoreModule.store", 'Редактирование категории'),],
                            ['type' => AuthItem::TYPE_OPERATION, 'name' => 'Store.CategoryBackend.View', 'description' => Yii::t("StoreModule.store", 'Просмотр категории'),],
                            ['type' => AuthItem::TYPE_OPERATION, 'name' => 'Store.CategoryBackend.Delete', 'description' => Yii::t("StoreModule.store", 'Удаление категории'),],
                        ],
                    ],
                    [
                        'type'        => AuthItem::TYPE_TASK,
                        'name'        => 'Store.ProducerBackend.Management',
                        'description' => Yii::t("StoreModule.store", 'Управление производителями'),
                        'items'       => [
                            ['type' => AuthItem::TYPE_OPERATION, 'name' => 'Store.ProducerBackend.Index', 'description' => Yii::t("StoreModule.store", 'Просмотр списка производителей'),],
                            ['type' => AuthItem::TYPE_OPERATION, 'name' => 'Store.ProducerBackend.Create', 'description' => Yii::t("StoreModule.store", 'Создание производителя'),],
                            ['type' => AuthItem::TYPE_OPERATION, 'name' => 'Store.ProducerBackend.Update', 'description' => Yii::t("StoreModule.store", 'Редактирование производителя'),],
                            ['type' => AuthItem::TYPE_OPERATION, 'name' => 'Store.ProducerBackend.View', 'description' => Yii::t("StoreModule.store", 'Просмотр производителя'),],
                            ['type' => AuthItem::TYPE_OPERATION, 'name' => 'Store.ProducerBackend.Delete', 'description' => Yii::t("StoreModule.store", 'Удаление производителя'),],
                        ],
                    ],
                    [
                        'type'        => AuthItem::TYPE_TASK,
                        'name'        => 'Store.ProductBackend.Management',
                        'description' => Yii::t("StoreModule.store", 'Управление товарами'),
                        'items'       => [
                            ['type' => AuthItem::TYPE_OPERATION, 'name' => 'Store.ProductBackend.Index', 'description' => Yii::t("StoreModule.store", 'Просмотр списка товаров'),],
                            ['type' => AuthItem::TYPE_OPERATION, 'name' => 'Store.ProductBackend.Create', 'description' => Yii::t("StoreModule.store", 'Создание товара'),],
                            ['type' => AuthItem::TYPE_OPERATION, 'name' => 'Store.ProductBackend.Update', 'description' => Yii::t("StoreModule.store", 'Редактирование товара'),],
                            ['type' => AuthItem::TYPE_OPERATION, 'name' => 'Store.ProductBackend.View', 'description' => Yii::t("StoreModule.store", 'Просмотр товара'),],
                            ['type' => AuthItem::TYPE_OPERATION, 'name' => 'Store.ProductBackend.Delete', 'description' => Yii::t("StoreModule.store", 'Удаление товара'),],
                        ],
                    ],
                    [
                        'type'        => AuthItem::TYPE_TASK,
                        'name'        => 'Store.TypeBackend.Management',
                        'description' => Yii::t("StoreModule.store", 'Управление типами товаров'),
                        'items'       => [
                            ['type' => AuthItem::TYPE_OPERATION, 'name' => 'Store.TypeBackend.Index', 'description' => Yii::t("StoreModule.store", 'Просмотр списка типов'),],
                            ['type' => AuthItem::TYPE_OPERATION, 'name' => 'Store.TypeBackend.Create', 'description' => Yii::t("StoreModule.store", 'Создание типа'),],
                            ['type' => AuthItem::TYPE_OPERATION, 'name' => 'Store.TypeBackend.Update', 'description' => Yii::t("StoreModule.store", 'Редактирование типа'),],
                            ['type' => AuthItem::TYPE_OPERATION, 'name' => 'Store.TypeBackend.View', 'description' => Yii::t("StoreModule.store", 'Просмотр типа'),],
                            ['type' => AuthItem::TYPE_OPERATION, 'name' => 'Store.TypeBackend.Delete', 'description' => Yii::t("StoreModule.store", 'Удаление типа'),],
                        ],
                    ],
                ],
            ],
        ];
    }
}
