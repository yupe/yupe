<?php

/**
 * ImageModule основной класс модуля image
 *
 * @author yupe team <team@yupe.ru>
 * @link http://yupe.ru
 * @copyright 2009-2013 amyLabs && Yupe! team
 * @package yupe.modules.image
 * @since 0.1
 *
 */

use yupe\components\WebModule;

/**
 * Class ImageModule
 */
class ImageModule extends WebModule
{
    /**
     *
     */
    const VERSION = '0.9.9';

    /**
     * @var string
     */
    public $uploadPath = 'image';
    /**
     * @var
     */
    public $documentRoot;
    /**
     * @var string
     */
    public $allowedExtensions = 'jpg,jpeg,png,gif';
    /**
     * @var int
     */
    public $minSize = 0;
    /**
     * @var int
     */
    public $maxSize = 5242880; /* 5 MB */
    /**
     * @var int
     */
    public $maxFiles = 1;
    /**
     * @var
     */
    public $types;
    /**
     * @var string
     */
    public $mimeTypes = 'image/gif, image/jpeg, image/png';

    /**
     * @var int
     */
    public $width = 950;
    /**
     * @var int
     */
    public $height = 950;

    /**
     * @return string
     */
    public function getUploadPath()
    {
        return Yii::app()->uploadManager->getBasePath().DIRECTORY_SEPARATOR.$this->uploadPath;
    }

    /**
     * @return bool
     */
    public function getInstall()
    {
        if (parent::getInstall()) {
            @mkdir($this->getUploadPath(), 0755);
        }

        return false;
    }

    /**
     * @return array
     */
    public function getDependencies()
    {
        return [
            'category',
        ];
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
    public function getIcon()
    {
        return 'fa fa-fw fa-picture-o';
    }

    /**
     * @return array
     */
    public function getParamsLabels()
    {
        return [
            'mainCategory' => Yii::t('ImageModule.image', 'Main images category'),
            'uploadPath' => Yii::t('ImageModule.image', 'Directory for uploading images'),
            'allowedExtensions' => Yii::t('ImageModule.image', 'Allowed extensions (separated by comma)'),
            'minSize' => Yii::t('ImageModule.image', 'Minimum size (in bytes)'),
            'maxSize' => Yii::t('ImageModule.image', 'Maximum size (in bytes)'),
            'mimeTypes' => Yii::t('ImageModule.image', 'Mime types'),
            'width' => Yii::t('ImageModule.image', 'Image width'),
            'height' => Yii::t('ImageModule.image', 'Image height'),
        ];
    }

    /**
     * @return array
     */
    public function getEditableParams()
    {
        return [
            'uploadPath',
            'allowedExtensions',
            'minSize',
            'maxSize',
            'mainCategory' => CHtml::listData($this->getCategoryList(), 'id', 'name'),
            'mimeTypes',
            'width',
            'height',
        ];
    }

    /**
     * @return array
     */
    public function getEditableParamsGroups()
    {
        return [
            '0.main' => [
                'label' => Yii::t('ImageModule.image', 'Download settings'),
                'items' => [
                    'allowedExtensions',
                    'mimeTypes',
                    'minSize',
                    'maxSize',
                    'uploadPath',
                    'mainCategory',
                ],
            ],
            '1.main' => [
                'label' => Yii::t('ImageModule.image', 'Resize settings'),
                'items' => [
                    'width',
                    'height',
                ],
            ],
        ];
    }

    /**
     * @return array|bool
     */
    public function checkSelf()
    {
        $messages = [];

        $uploadPath = Yii::app()->uploadManager->getBasePath().DIRECTORY_SEPARATOR.$this->uploadPath;

        if (!$uploadPath) {
            $messages[WebModule::CHECK_ERROR][] = [
                'type' => WebModule::CHECK_ERROR,
                'message' => Yii::t(
                    'ImageModule.image',
                    'Please, choose catalog for images! {link}',
                    [
                        '{link}' => CHtml::link(
                            Yii::t('ImageModule.image', 'Change module settings'),
                            [
                                '/yupe/backend/modulesettings/',
                                'module' => $this->id,
                            ]
                        ),
                    ]
                ),
            ];
        }

        if (!is_dir($uploadPath) || !is_writable($uploadPath)) {
            $messages[WebModule::CHECK_ERROR][] = [
                'type' => WebModule::CHECK_ERROR,
                'message' => Yii::t(
                    'ImageModule.image',
                    'Directory "{dir}" is not accessible for writing ot not exists! {link}',
                    [
                        '{dir}' => $uploadPath,
                        '{link}' => CHtml::link(
                            Yii::t('ImageModule.image', 'Change module settings'),
                            [
                                '/yupe/backend/modulesettings/',
                                'module' => $this->id,
                            ]
                        ),
                    ]
                ),
            ];
        }

        if (!$this->maxSize || $this->maxSize <= 0) {
            $messages[WebModule::CHECK_ERROR][] = [
                'type' => WebModule::CHECK_ERROR,
                'message' => Yii::t(
                    'ImageModule.image',
                    'Set maximum images size {link}',
                    [
                        '{link}' => CHtml::link(
                            Yii::t('ImageModule.image', 'Change module settings'),
                            [
                                '/yupe/backend/modulesettings/',
                                'module' => $this->id,
                            ]
                        ),
                    ]
                ),
            ];
        }

        return (isset($messages[WebModule::CHECK_ERROR])) ? $messages : true;
    }

    /**
     * @return string
     */
    public function getCategory()
    {
        return Yii::t('ImageModule.image', 'Content');
    }

    /**
     * @return string
     */
    public function getName()
    {
        return Yii::t('ImageModule.image', 'Images');
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return Yii::t('ImageModule.image', 'Module for images management');
    }

    /**
     * @return string
     */
    public function getAuthor()
    {
        return Yii::t('ImageModule.image', 'yupe team');
    }

    /**
     * @return string
     */
    public function getAuthorEmail()
    {
        return Yii::t('ImageModule.image', 'team@yupe.ru');
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return Yii::t('ImageModule.image', 'http://yupe.ru');
    }

    /**
     *
     */
    public function init()
    {
        parent::init();

        $this->documentRoot = $_SERVER['DOCUMENT_ROOT'];

        $forImport = [];

        if (Yii::app()->hasModule('gallery')) {
            $forImport[] = 'gallery.models.*';
        }

        $this->setImport(
            array_merge(
                [
                    'image.models.*',
                ],
                $forImport
            )
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
                'label' => Yii::t('ImageModule.image', 'Images list'),
                'url' => ['/image/imageBackend/index'],
            ],
            [
                'icon' => 'fa fa-fw fa-plus-square',
                'label' => Yii::t('ImageModule.image', 'Add image'),
                'url' => ['/image/imageBackend/create'],
            ],
            [
                'icon' => 'fa fa-fw fa-folder-open',
                'label' => Yii::t('ImageModule.image', 'Images categories'),
                'url' => ['/category/categoryBackend/index', 'Category[parent_id]' => (int)$this->mainCategory],
            ],
        ];
    }

    /**
     * @return string
     */
    public function getAdminPageLink()
    {
        return '/image/imageBackend/index';
    }

    /**
     * Получаем разрешённые форматы:
     *
     * @return array of allowed extensions
     **/
    public function allowedExtensions()
    {
        return explode(',', $this->allowedExtensions);
    }

    /**
     * @return array
     */
    public function getAuthItems()
    {
        return [
            [
                'name' => 'Image.ImageManager',
                'description' => Yii::t('ImageModule.image', 'Manage images'),
                'type' => AuthItem::TYPE_TASK,
                'items' => [
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'Image.ImageBackend.Create',
                        'description' => Yii::t('ImageModule.image', 'Creating image'),
                    ],
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'Image.ImageBackend.Delete',
                        'description' => Yii::t('ImageModule.image', 'Removing image'),
                    ],
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'Image.ImageBackend.Index',
                        'description' => Yii::t('ImageModule.image', 'List of images'),
                    ],
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'Image.ImageBackend.Update',
                        'description' => Yii::t('ImageModule.image', 'Editing images'),
                    ],
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'Image.ImageBackend.View',
                        'description' => Yii::t('ImageModule.image', 'Viewing images'),
                    ],
                ],
            ],
        ];
    }
}
