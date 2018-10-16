<?php
/**
 * CatalogModule основной класс модуля catalog
 *
 * @author yupe team <team@yupe.ru>
 * @link http://yupe.ru
 * @copyright 2009-2013 amyLabs && Yupe! team
 * @package yupe.modules.catalog
 * @since 0.1
 *
 */

use yupe\components\WebModule;

class CatalogModule extends WebModule
{
    const VERSION = '0.9.2';

    public $uploadPath = 'catalog';
    public $allowedExtensions = 'jpg,jpeg,png,gif';
    public $minSize = 0;
    public $maxSize = 5242880;
    public $maxFiles = 1;

    public function getDependencies()
    {
        return [
            'user',
            'category'
        ];
    }

    public function checkSelf()
    {
        $messages = [];

        $uploadPath = Yii::app()->uploadManager->getBasePath() . DIRECTORY_SEPARATOR . $this->uploadPath;

        if (!is_writable($uploadPath)) {
            $messages[WebModule::CHECK_ERROR][] = [
                'type'    => WebModule::CHECK_ERROR,
                'message' => Yii::t(
                        'CatalogModule.catalog',
                        'Directory "{dir}" is not writeable! {link}',
                        [
                            '{dir}'  => $uploadPath,
                            '{link}' => CHtml::link(
                                    Yii::t('CatalogModule.catalog', 'Change settings'),
                                    [
                                        '/yupe/backend/modulesettings/',
                                        'module' => 'catalog',
                                    ]
                                ),
                        ]
                    ),
            ];
        }

        return isset($messages[WebModule::CHECK_ERROR]) ? $messages : true;
    }

    public function getInstall()
    {
        if (parent::getInstall()) {
            @mkdir(Yii::app()->uploadManager->getBasePath() . DIRECTORY_SEPARATOR . $this->uploadPath, 0755);
        }

        return false;
    }

    public function getEditableParams()
    {
        return [
            'mainCategory' => CHtml::listData($this->getCategoryList(), 'id', 'name'),
            'uploadPath',
            'adminMenuOrder',
            'editor'       => Yii::app()->getModule('yupe')->editors,
            'allowedExtensions',
            'minSize',
            'maxSize',
        ];
    }

    public function getParamsLabels()
    {
        return [
            'mainCategory'      => Yii::t('CatalogModule.catalog', 'Main category of products'),
            'adminMenuOrder'    => Yii::t('CatalogModule.catalog', 'Menu items order'),
            'uploadPath'        => Yii::t(
                    'CatalogModule.catalog',
                    'File uploads directory (relative to {dir})',
                    ['{dir}' => Yii::app()->getModule("yupe")->uploadPath]
                ),
            'editor'            => Yii::t('CatalogModule.catalog', 'Visual editor'),
            'allowedExtensions' => Yii::t('CatalogModule.catalog', 'Accepted extensions (separated by comma)'),
            'minSize'           => Yii::t('CatalogModule.catalog', 'Minimum size (in bytes)'),
            'maxSize'           => Yii::t('CatalogModule.catalog', 'Maximum size (in bytes)'),
        ];
    }

    public function getNavigation()
    {
        return [
            [
                'icon'  => 'fa fa-fw fa-list-alt',
                'label' => Yii::t('CatalogModule.catalog', 'Product list'),
                'url'   => ['/catalog/catalogBackend/index']
            ],
            [
                'icon'  => 'fa fa-fw fa-plus-square',
                'label' => Yii::t('CatalogModule.catalog', 'Add a product'),
                'url'   => ['/catalog/catalogBackend/create']
            ],
            [
                'icon'  => 'fa fa-fw fa-folder-open',
                'label' => Yii::t('CatalogModule.catalog', 'Goods categories'),
                'url'   => ['/category/categoryBackend/index', 'Category[parent_id]' => (int)$this->mainCategory]
            ],
        ];
    }

    public function getAdminPageLink()
    {
        return '/catalog/catalogBackend/index';
    }

    public function getVersion()
    {
        return self::VERSION;
    }

    public function getCategory()
    {
        return Yii::t('CatalogModule.catalog', 'Content');
    }

    public function getName()
    {
        return Yii::t('CatalogModule.catalog', 'Catalog');
    }

    public function getDescription()
    {
        return Yii::t('CatalogModule.catalog', 'This module allows creating a simple product catalog');
    }

    public function getAuthor()
    {
        return Yii::t('CatalogModule.catalog', 'yupe team');
    }

    public function getAuthorEmail()
    {
        return Yii::t('CatalogModule.catalog', 'team@yupe.ru');
    }

    public function getUrl()
    {
        return Yii::t('CatalogModule.catalog', 'http://yupe.ru');
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
                'catalog.models.*',
                'catalog.components.*',
            ]
        );
    }

    public function getAuthItems()
    {
        return [
            [
                'name'        => 'Catalog.CatalogManager',
                'description' => Yii::t('CatalogModule.catalog', 'Manage catalog'),
                'type'        => AuthItem::TYPE_TASK,
                'items'       => [
                    [
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'Catalog.CatalogBackend.Create',
                        'description' => Yii::t('CatalogModule.catalog', 'Creating good')
                    ],
                    [
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'Catalog.CatalogBackend.Delete',
                        'description' => Yii::t('CatalogModule.catalog', 'Removing good')
                    ],
                    [
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'Catalog.CatalogBackend.Index',
                        'description' => Yii::t('CatalogModule.catalog', 'List of goods')
                    ],
                    [
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'Catalog.CatalogBackend.Update',
                        'description' => Yii::t('CatalogModule.catalog', 'Editing goods')
                    ],
                    [
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'Catalog.CatalogBackend.Inline',
                        'description' => Yii::t('CatalogModule.catalog', 'Editing goods')
                    ],
                    [
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'Catalog.CatalogBackend.View',
                        'description' => Yii::t('CatalogModule.catalog', 'Viewing goods')
                    ],
                ]
            ]
        ];
    }
}
