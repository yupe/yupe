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

class ImageModule extends WebModule
{
    const VERSION = '0.9';

    public $uploadPath = 'image';
    public $documentRoot;
    public $allowedExtensions = 'jpg,jpeg,png,gif';
    public $minSize = 0;
    public $maxSize = 5242880 /* 5 MB */
    ;
    public $maxFiles = 1;
    public $types;
    public $mimeTypes = 'image/gif, image/jpeg, image/png';

    public function getUploadPath()
    {
        return Yii::app()->uploadManager->getBasePath() . DIRECTORY_SEPARATOR . $this->uploadPath;
    }

    public function getInstall()
    {
        if (parent::getInstall()) {
            @mkdir($this->getUploadPath(), 0755);
        }

        return false;
    }

    public function getDependencies()
    {
        return array(
            'category',
        );
    }

    public function getVersion()
    {
        return self::VERSION;
    }

    public function getIcon()
    {
        return "fa fa-fw fa-picture-o";
    }

    public function getParamsLabels()
    {
        return array(
            'mainCategory'      => Yii::t('ImageModule.image', 'Main images category'),
            'uploadPath'        => Yii::t('ImageModule.image', 'Directory for uploading images'),
            'allowedExtensions' => Yii::t('ImageModule.image', 'Allowed extensions (separated by comma)'),
            'minSize'           => Yii::t('ImageModule.image', 'Minimum size (in bytes)'),
            'maxSize'           => Yii::t('ImageModule.image', 'Maximum size (in bytes)'),
            'mimeTypes'         => Yii::t('ImageModule.image', 'Mime types')
        );
    }

    public function getEditableParams()
    {
        return array(
            'uploadPath',
            'allowedExtensions',
            'minSize',
            'maxSize',
            'mainCategory' => CHtml::listData($this->getCategoryList(), 'id', 'name'),
            'mimeTypes'
        );
    }

    public function getEditableParamsGroups()
    {
        return array(
            'main' => array(
                'label' => Yii::t('ImageModule.image', 'General module settings'),
                'items' => array(
                    'allowedExtensions',
                    'mimeTypes',
                    'minSize',
                    'maxSize',
                    'uploadPath',
                    'mainCategory'
                )
            )
        );
    }

    public function checkSelf()
    {
        $messages = array();

        $uploadPath = Yii::app()->uploadManager->getBasePath() . DIRECTORY_SEPARATOR . $this->uploadPath;

        if (!$uploadPath) {
            $messages[WebModule::CHECK_ERROR][] = array(
                'type'    => WebModule::CHECK_ERROR,
                'message' => Yii::t(
                        'ImageModule.image',
                        'Please, choose catalog for images! {link}',
                        array(
                            '{link}' => CHtml::link(
                                    Yii::t('ImageModule.image', 'Change module settings'),
                                    array(
                                        '/yupe/backend/modulesettings/',
                                        'module' => $this->id,
                                    )
                                ),
                        )
                    ),
            );
        }

        if (!is_dir($uploadPath) || !is_writable($uploadPath)) {
            $messages[WebModule::CHECK_ERROR][] = array(
                'type'    => WebModule::CHECK_ERROR,
                'message' => Yii::t(
                        'ImageModule.image',
                        'Directory "{dir}" is not accessible for writing ot not exists! {link}',
                        array(
                            '{dir}'  => $uploadPath,
                            '{link}' => CHtml::link(
                                    Yii::t('ImageModule.image', 'Change module settings'),
                                    array(
                                        '/yupe/backend/modulesettings/',
                                        'module' => $this->id,
                                    )
                                ),
                        )
                    ),
            );
        }

        if (!$this->maxSize || $this->maxSize <= 0) {
            $messages[WebModule::CHECK_ERROR][] = array(
                'type'    => WebModule::CHECK_ERROR,
                'message' => Yii::t(
                        'ImageModule.image',
                        'Set maximum images size {link}',
                        array(
                            '{link}' => CHtml::link(
                                    Yii::t('ImageModule.image', 'Change module settings'),
                                    array(
                                        '/yupe/backend/modulesettings/',
                                        'module' => $this->id,
                                    )
                                ),
                        )
                    ),
            );
        }

        return (isset($messages[WebModule::CHECK_ERROR])) ? $messages : true;
    }

    public function getCategory()
    {
        return Yii::t('ImageModule.image', 'Content');
    }

    public function getName()
    {
        return Yii::t('ImageModule.image', 'Images');
    }

    public function getDescription()
    {
        return Yii::t('ImageModule.image', 'Module for images management');
    }

    public function getAuthor()
    {
        return Yii::t('ImageModule.image', 'yupe team');
    }

    public function getAuthorEmail()
    {
        return Yii::t('ImageModule.image', 'team@yupe.ru');
    }

    public function getUrl()
    {
        return Yii::t('ImageModule.image', 'http://yupe.ru');
    }

    public function init()
    {
        parent::init();

        $this->documentRoot = $_SERVER['DOCUMENT_ROOT'];

        $forImport = array();

        if (Yii::app()->hasModule('gallery')) {
            $forImport[] = 'gallery.models.*';
        }

        $this->setImport(
            array_merge(
                array(
                    'image.models.*'
                ),
                $forImport
            )
        );
    }

    public function getNavigation()
    {
        return array(
            array(
                'icon'  => 'fa fa-fw fa-list-alt',
                'label' => Yii::t('ImageModule.image', 'Images list'),
                'url'   => array('/image/imageBackend/index')
            ),
            array(
                'icon'  => 'fa fa-fw fa-plus-square',
                'label' => Yii::t('ImageModule.image', 'Add image'),
                'url'   => array('/image/imageBackend/create')
            ),
            array(
                'icon'  => 'fa fa-fw fa-folder-open',
                'label' => Yii::t('ImageModule.image', 'Images categories'),
                'url'   => array('/category/categoryBackend/index', 'Category[parent_id]' => (int)$this->mainCategory)
            ),
        );
    }

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

    public function getAuthItems()
    {
        return array(
            array(
                'name'        => 'Image.ImageManager',
                'description' => Yii::t('ImageModule.image', 'Manage images'),
                'type'        => AuthItem::TYPE_TASK,
                'items'       => array(
                    array(
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'Image.ImageBackend.Create',
                        'description' => Yii::t('ImageModule.image', 'Creating image')
                    ),
                    array(
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'Image.ImageBackend.Delete',
                        'description' => Yii::t('ImageModule.image', 'Removing image')
                    ),
                    array(
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'Image.ImageBackend.Index',
                        'description' => Yii::t('ImageModule.image', 'List of images')
                    ),
                    array(
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'Image.ImageBackend.Update',
                        'description' => Yii::t('ImageModule.image', 'Editing images')
                    ),
                    array(
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'Image.ImageBackend.Inline',
                        'description' => Yii::t('ImageModule.image', 'Editing images')
                    ),
                    array(
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'Image.ImageBackend.View',
                        'description' => Yii::t('ImageModule.image', 'Viewing images')
                    ),
                )
            )
        );
    }
}
