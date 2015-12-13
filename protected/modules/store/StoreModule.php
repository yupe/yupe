<?php

use yupe\components\WebModule;

/**
 * Class StoreModule
 */
class StoreModule extends WebModule
{
    /**
     *
     */
    const VERSION = '0.9.9';

    /**
     * @var
     */
    public $phone;

    /**
     * @var
     */
    public $email;

    public $currency = 'RUB';

    /**
     * @var string
     */
    public $uploadPath = 'store';
    /**
     * @var string
     */
    public $allowedExtensions = 'jpg,jpeg,png,gif';
    /**
     * @var int
     */
    public $minSize = 0;
    /**
     * @var
     */
    public $maxSize;
    /**
     * @var int
     */
    public $maxFiles = 1;
    /**
     * @var string
     */
    public $assetsPath = 'application.modules.store.views.assets';
    /**
     * @var string
     */
    public $defaultImage = '/images/nophoto.jpg';
    /**
     * @var int
     */
    public $itemsPerPage = 20;

    /**
     * @return string
     */
    public function getUploadPath()
    {
        return Yii::getPathOfAlias('webroot').'/'.Yii::app()->getModule(
            'yupe'
        )->uploadPath.'/'.$this->uploadPath;
    }

    /**
     * @return array|bool
     */
    public function checkSelf()
    {
        $messages = [];

        return isset($messages[WebModule::CHECK_ERROR]) ? $messages : true;
    }

    /**
     * @return bool
     */
    public function getInstall()
    {
        if (parent::getInstall()) {
            @mkdir($this->getUploadPath(), 0755);
        }

        return true;
    }

    public function getCurrencyList()
    {
        return [
            'USD' => 'USD',
            'RUB' => 'RUB',
            'EUR' => 'EUR'
        ];
    }


    /**
     * @return array
     */
    public function getEditableParams()
    {
        return [
            'uploadPath',
            'editor' => Yii::app()->getModule('yupe')->editors,
            'itemsPerPage',
            'phone',
            'email',
            'currency' => $this->getCurrencyList()
        ];
    }

    /**
     * @return array
     */
    public function getParamsLabels()
    {
        return [
            'uploadPath' => Yii::t(
                'StoreModule.store',
                'File uploads directory (relative to "{path}")',
                ['{path}' => Yii::getPathOfAlias('webroot').'/'.Yii::app()->getModule("yupe")->uploadPath]
            ),
            'editor' => Yii::t('StoreModule.store', 'Visual editor'),
            'defaultImage' => Yii::t('StoreModule.store', 'Default image'),
            'itemsPerPage' => Yii::t('StoreModule.store', 'Items per page'),
            'phone' => Yii::t('StoreModule.store', 'Phone'),
            'email' => Yii::t('StoreModule.store', 'Email'),
            'currency' => Yii::t('StoreModule.store', 'Currency')
        ];
    }

    /**
     * @return array
     */
    public function getEditableParamsGroups()
    {
        return [
            '0.store' => [
                'label' => Yii::t('StoreModule.store', 'Store'),
                'items' => [
                    'phone',
                    'email',
                    'itemsPerPage'
                ],
            ],
            '1.store' => [
                'label' => Yii::t('StoreModule.store', 'Currency'),
                'items' => [
                    'currency'
                ],
            ],
            '2.main' => [
                'label' => Yii::t('StoreModule.store', 'Images'),
                'items' => [
                    'uploadPath',
                    'defaultImage',
                ],
            ],
            '3.main' => [
                'label' => Yii::t('StoreModule.store', 'Visual editor settings'),
                'items' => [
                    'editor',
                ],
            ],
        ];
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
    public function getIsShowInAdminMenu()
    {
        return true;
    }

    /**
     * @return array
     */
    public function getExtendedNavigation()
    {
        return [
            [
                'icon' => 'fa fa-fw fa-shopping-cart',
                'label' => Yii::t('StoreModule.store', 'Catalog'),
                'items' => [
                    [
                        'icon' => 'fa fa-fw fa-reorder',
                        'label' => Yii::t('StoreModule.store', 'Products'),
                        'url' => ['/store/productBackend/index'],
                        'items' => [
                            [
                                'icon' => 'fa fa-fw fa-list-alt',
                                'label' => Yii::t('StoreModule.store', 'Product list'),
                                'url' => ['/store/productBackend/index'],
                            ],
                            [
                                'icon' => 'fa fa-fw fa-plus-square',
                                'label' => Yii::t('StoreModule.store', 'Create product'),
                                'url' => ['/store/productBackend/create'],
                            ],
                            [
                                'icon' => 'fa fa-fw fa-link',
                                'label' => Yii::t('StoreModule.store', 'Link types'),
                                'url' => ['/store/linkBackend/typeIndex'],
                            ],
                        ],
                    ],
                    [
                        'icon' => 'fa fa-fw fa-list-alt',
                        'label' => Yii::t('StoreModule.type', 'Types'),
                        'url' => ['/store/typeBackend/index'],
                        'items' => [
                            [
                                'icon' => 'fa fa-fw fa-list-alt',
                                'label' => Yii::t('StoreModule.type', 'Types list'),
                                'url' => ['/store/typeBackend/index'],
                            ],
                            [
                                'icon' => 'fa fa-fw fa-plus-square',
                                'label' => Yii::t('StoreModule.type', 'Create type'),
                                'url' => ['/store/typeBackend/create'],
                            ],
                        ],
                    ],
                    [
                        'icon' => 'fa fa-fw fa-pencil-square-o',
                        'label' => Yii::t('StoreModule.attr', 'Attributes'),
                        'url' => ['/store/attributeBackend/index'],
                        'items' => [
                            [
                                'icon' => 'fa fa-fw fa-list-alt',
                                'label' => Yii::t('StoreModule.attr', 'Attributes list'),
                                'url' => ['/store/attributeBackend/index'],
                            ],
                            [
                                'icon' => 'fa fa-fw fa-plus-square',
                                'label' => Yii::t('StoreModule.attr', 'Create attribute'),
                                'url' => ['/store/attributeBackend/create'],
                            ],
                        ],
                    ],
                    [
                        'icon' => 'fa fa-fw fa-folder-open',
                        'label' => Yii::t('StoreModule.category', 'Categories'),
                        'url' => ['/store/categoryBackend/index'],
                        'items' => [
                            [
                                'icon' => 'fa fa-fw fa-list-alt',
                                'label' => Yii::t('StoreModule.category', 'Categories list'),
                                'url' => ['/store/categoryBackend/index'],
                            ],
                            [
                                'icon' => 'fa fa-fw fa-plus-square',
                                'label' => Yii::t('StoreModule.category', 'Create category'),
                                'url' => ['/store/categoryBackend/create'],
                            ],
                        ],
                    ],
                    [
                        'icon' => 'fa fa-fw fa-plane',
                        'label' => Yii::t('StoreModule.producer', 'Producers'),
                        'url' => ['/store/producerBackend/index'],
                        'items' => [
                            [
                                'icon' => 'fa fa-fw fa-list-alt',
                                'label' => Yii::t('StoreModule.producer', 'Producers list'),
                                'url' => ['/store/producerBackend/index'],
                            ],
                            [
                                'icon' => 'fa fa-fw fa-plus-square',
                                'label' => Yii::t('StoreModule.producer', 'Create producer'),
                                'url' => ['/store/producerBackend/create'],
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    /**
     * @return string
     */
    public function getAdminPageLink()
    {
        return '/store/storeBackend/index';
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
    public function getCategory()
    {
        return Yii::t('StoreModule.store', 'Store');
    }

    /**
     * @return string
     */
    public function getName()
    {
        return Yii::t('StoreModule.store', 'Store');
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return Yii::t('StoreModule.store', 'Store module');
    }

    /**
     * @return string
     */
    public function getAuthor()
    {
        return Yii::t('StoreModule.store', 'amylabs team');
    }

    /**
     * @return string
     */
    public function getAuthorEmail()
    {
        return Yii::t('StoreModule.store', 'hello@amylabs.ru');
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return 'http://yupe-project.ru';
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
                'application.modules.store.models.*',
                'application.modules.store.forms.*',
                'application.modules.store.components.*',
            ]
        );
    }

    /**
     * @return array
     */
    public function getAuthItems()
    {
        return [
            [
                'type' => AuthItem::TYPE_ROLE,
                'name' => 'Store.Manager',
                'description' => Yii::t('StoreModule.store', 'Catalog manager'),
                'items' => [
                    [
                        'type' => AuthItem::TYPE_TASK,
                        'name' => 'Store.AttributeBackend.Management',
                        'description' => Yii::t('StoreModule.attr', 'Manage product attributes'),
                        'items' => [
                            [
                                'type' => AuthItem::TYPE_OPERATION,
                                'name' => 'Store.AttributeBackend.Index',
                                'description' => Yii::t('StoreModule.attr', 'View attribute list'),
                            ],
                            [
                                'type' => AuthItem::TYPE_OPERATION,
                                'name' => 'Store.AttributeBackend.Create',
                                'description' => Yii::t('StoreModule.attr', 'Create attribute'),
                            ],
                            [
                                'type' => AuthItem::TYPE_OPERATION,
                                'name' => 'Store.AttributeBackend.Update',
                                'description' => Yii::t('StoreModule.attr', 'Update attribute'),
                            ],
                            [
                                'type' => AuthItem::TYPE_OPERATION,
                                'name' => 'Store.AttributeBackend.View',
                                'description' => Yii::t('StoreModule.attr', 'View attribute'),
                            ],
                            [
                                'type' => AuthItem::TYPE_OPERATION,
                                'name' => 'Store.AttributeBackend.Delete',
                                'description' => Yii::t('StoreModule.attr', 'Delete attribute'),
                            ],
                        ],
                    ],
                    [
                        'type' => AuthItem::TYPE_TASK,
                        'name' => 'Store.CategoryBackend.Management',
                        'description' => Yii::t('StoreModule.category', 'Manage product categories'),
                        'items' => [
                            [
                                'type' => AuthItem::TYPE_OPERATION,
                                'name' => 'Store.CategoryBackend.Index',
                                'description' => Yii::t('StoreModule.category', 'List of categories'),
                            ],
                            [
                                'type' => AuthItem::TYPE_OPERATION,
                                'name' => 'Store.CategoryBackend.Create',
                                'description' => Yii::t('StoreModule.category', 'Create category'),
                            ],
                            [
                                'type' => AuthItem::TYPE_OPERATION,
                                'name' => 'Store.CategoryBackend.Update',
                                'description' => Yii::t('StoreModule.category', 'Update category'),
                            ],
                            [
                                'type' => AuthItem::TYPE_OPERATION,
                                'name' => 'Store.CategoryBackend.View',
                                'description' => Yii::t('StoreModule.category', 'View category'),
                            ],
                            [
                                'type' => AuthItem::TYPE_OPERATION,
                                'name' => 'Store.CategoryBackend.Delete',
                                'description' => Yii::t('StoreModule.category', 'Delete category'),
                            ],
                        ],
                    ],
                    [
                        'type' => AuthItem::TYPE_TASK,
                        'name' => 'Store.ProducerBackend.Management',
                        'description' => Yii::t('StoreModule.producer', 'Manage producers'),
                        'items' => [
                            [
                                'type' => AuthItem::TYPE_OPERATION,
                                'name' => 'Store.ProducerBackend.Index',
                                'description' => Yii::t('StoreModule.producer', 'View producer list'),
                            ],
                            [
                                'type' => AuthItem::TYPE_OPERATION,
                                'name' => 'Store.ProducerBackend.Create',
                                'description' => Yii::t('StoreModule.producer', 'Create producer'),
                            ],
                            [
                                'type' => AuthItem::TYPE_OPERATION,
                                'name' => 'Store.ProducerBackend.Update',
                                'description' => Yii::t('StoreModule.producer', 'Update producer'),
                            ],
                            [
                                'type' => AuthItem::TYPE_OPERATION,
                                'name' => 'Store.ProducerBackend.View',
                                'description' => Yii::t('StoreModule.producer', 'View producer'),
                            ],
                            [
                                'type' => AuthItem::TYPE_OPERATION,
                                'name' => 'Store.ProducerBackend.Delete',
                                'description' => Yii::t('StoreModule.producer', 'Delete producer'),
                            ],
                        ],
                    ],
                    [
                        'type' => AuthItem::TYPE_TASK,
                        'name' => 'Store.ProductBackend.Management',
                        'description' => Yii::t('StoreModule.store', 'Manage products'),
                        'items' => [
                            [
                                'type' => AuthItem::TYPE_OPERATION,
                                'name' => 'Store.ProductBackend.Index',
                                'description' => Yii::t('StoreModule.store', 'View product list'),
                            ],
                            [
                                'type' => AuthItem::TYPE_OPERATION,
                                'name' => 'Store.ProductBackend.Create',
                                'description' => Yii::t('StoreModule.store', 'Create product'),
                            ],
                            [
                                'type' => AuthItem::TYPE_OPERATION,
                                'name' => 'Store.ProductBackend.Update',
                                'description' => Yii::t('StoreModule.store', 'Update product'),
                            ],
                            [
                                'type' => AuthItem::TYPE_OPERATION,
                                'name' => 'Store.ProductBackend.View',
                                'description' => Yii::t('StoreModule.store', 'View product'),
                            ],
                            [
                                'type' => AuthItem::TYPE_OPERATION,
                                'name' => 'Store.ProductBackend.Delete',
                                'description' => Yii::t('StoreModule.store', 'Delete product'),
                            ],
                        ],
                    ],
                    [
                        'type' => AuthItem::TYPE_TASK,
                        'name' => 'Store.TypeBackend.Management',
                        'description' => Yii::t('StoreModule.type', 'Manage product types'),
                        'items' => [
                            [
                                'type' => AuthItem::TYPE_OPERATION,
                                'name' => 'Store.TypeBackend.Index',
                                'description' => Yii::t('StoreModule.type', 'Types list'),
                            ],
                            [
                                'type' => AuthItem::TYPE_OPERATION,
                                'name' => 'Store.TypeBackend.Create',
                                'description' => Yii::t('StoreModule.type', 'Types list'),
                            ],
                            [
                                'type' => AuthItem::TYPE_OPERATION,
                                'name' => 'Store.TypeBackend.Update',
                                'description' => Yii::t('StoreModule.type', 'Update type'),
                            ],
                            [
                                'type' => AuthItem::TYPE_OPERATION,
                                'name' => 'Store.TypeBackend.View',
                                'description' => Yii::t('StoreModule.type', 'View type'),
                            ],
                            [
                                'type' => AuthItem::TYPE_OPERATION,
                                'name' => 'Store.TypeBackend.Delete',
                                'description' => Yii::t('StoreModule.type', 'Delete type'),
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }
}
