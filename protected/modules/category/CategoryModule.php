<?php
/**
 * CategoryModule основной класс модуля category
 *
 * @author yupe team <team@yupe.ru>
 * @link http://yupe.ru
 * @copyright 2009-2013 amyLabs && Yupe! team
 * @package yupe.modules.category
 * @since 0.1
 *
 */

use yupe\components\WebModule;

/**
 * Class CategoryModule
 */
class CategoryModule extends WebModule
{
    /**
     *
     */
    const VERSION = '0.9.9';

    /**
     * @var string
     */
    public $uploadPath = 'category';

    /**
     * @return array|bool
     */
    public function checkSelf()
    {
        $messages = [];

        $uploadPath = Yii::app()->uploadManager->getBasePath().DIRECTORY_SEPARATOR.$this->uploadPath;

        if (!is_writable($uploadPath)) {
            $messages[WebModule::CHECK_ERROR][] = [
                'type' => WebModule::CHECK_ERROR,
                'message' => Yii::t(
                    'CategoryModule.category',
                    'Directory "{dir}" is available for write! {link}',
                    [
                        '{dir}' => $uploadPath,
                        '{link}' => CHtml::link(
                            Yii::t('CategoryModule.category', 'Change settings'),
                            [
                                '/yupe/backend/modulesettings/',
                                'module' => 'category',
                            ]
                        ),
                    ]
                ),
            ];
        }

        return isset($messages[WebModule::CHECK_ERROR]) ? $messages : true;
    }

    /**
     * @return bool
     */
    public function getInstall()
    {
        if (parent::getInstall()) {
            @mkdir(Yii::app()->uploadManager->getBasePath().DIRECTORY_SEPARATOR.$this->uploadPath, 0755);
        }

        return false;
    }

    /**
     * @return array
     */
    public function getEditableParams()
    {
        return [
            'uploadPath',
        ];
    }

    /**
     * @return array
     */
    public function getParamsLabels()
    {
        return [
            'uploadPath' => Yii::t(
                'CategoryModule.category',
                'File uploading catalog (uploads)'
            ),
        ];
    }

    /**
     * @return bool
     */
    public function getIsInstallDefault()
    {
        return true;
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
        return Yii::t('CategoryModule.category', 'Structure');
    }

    /**
     * @return string
     */
    public function getName()
    {
        return Yii::t('CategoryModule.category', 'Categories');
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return Yii::t('CategoryModule.category', 'Module for categories/sections management');
    }

    /**
     * @return string
     */
    public function getAuthor()
    {
        return Yii::t('CategoryModule.category', 'yupe team');
    }

    /**
     * @return string
     */
    public function getAuthorEmail()
    {
        return Yii::t('CategoryModule.category', 'team@yupe.ru');
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return Yii::t('CategoryModule.category', 'http://yupe.ru');
    }

    /**
     * @return string
     */
    public function getIcon()
    {
        return 'fa fa-fw fa-folder-open';
    }

    /**
     * @return bool
     */
    public function isMultiLang()
    {
        return true;
    }

    /**
     *
     */
    public function init()
    {
        parent::init();

        $this->setImport(
            [
                'category.models.*',
                'category.components.*',
            ]
        );
    }

    /**
     * @return array
     */
    public function getNavigation()
    {
        return [
            [
                'icon' => 'fa fa-fw fa-list-alt',
                'label' => Yii::t('CategoryModule.category', 'Categories list'),
                'url' => ['/category/categoryBackend/index'],
            ],
            [
                'icon' => 'fa fa-fw fa-plus-square',
                'label' => Yii::t('CategoryModule.category', 'Create category'),
                'url' => ['/category/categoryBackend/create'],
            ],
        ];
    }

    /**
     * @return string
     */
    public function getAdminPageLink()
    {
        return '/category/categoryBackend/index';
    }

    /**
     * @return array
     */
    public function getAuthItems()
    {
        return [
            [
                'name' => 'Category.CategoryManager',
                'description' => Yii::t('CategoryModule.category', 'Manage categories'),
                'type' => AuthItem::TYPE_TASK,
                'items' => [
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'Category.CategoryBackend.Create',
                        'description' => Yii::t('CategoryModule.category', 'Creating category'),
                    ],
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'Category.CategoryBackend.Delete',
                        'description' => Yii::t('CategoryModule.category', 'Removing category'),
                    ],
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'Category.CategoryBackend.Index',
                        'description' => Yii::t('CategoryModule.category', 'List of categories'),
                    ],
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'Category.CategoryBackend.Update',
                        'description' => Yii::t('CategoryModule.category', 'Editing categories'),
                    ],
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'Category.CategoryBackend.View',
                        'description' => Yii::t('CategoryModule.category', 'Viewing categories'),
                    ],
                ],
            ],
        ];
    }
}
