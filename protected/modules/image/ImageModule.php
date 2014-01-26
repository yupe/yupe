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
    public $uploadPath        = 'image';
    public $documentRoot;
    public $allowedExtensions = 'jpg,jpeg,png,gif';
    public $minSize           = 0;
    public $maxSize           = 5242880 /* 5 MB */;
    public $maxFiles          = 1;
    public $types;

    public function getInstall()
    {
        if(parent::getInstall()) {
            @mkdir($this->getUploadPath(),0755);
        }

        return false;
    }

    public function getUploadPath()
    {
        return  Yii::getPathOfAlias('webroot') . '/' .
            Yii::app()->getModule('yupe')->uploadPath . '/' .
            $this->uploadPath . '/';
    }

    public function getDependencies()
    {
        return array(
            'category',
        );
    }

    public  function getVersion()
    {
        return Yii::t('ImageModule.image', '0.6');
    }

    public function getIcon()
    {
        return "picture-o";
    }

    public function getParamsLabels()
    {
        return array(
            'mainCategory'      => Yii::t('ImageModule.image','Main images category'),
            'uploadPath'        => Yii::t('ImageModule.image', 'Directory for uploading images'),
            'allowedExtensions' => Yii::t('ImageModule.image', 'Allowed extensions (separated by comma)'),
            'minSize'           => Yii::t('ImageModule.image', 'Minimum size (in bytes)'),
            'maxSize'           => Yii::t('ImageModule.image', 'Maximum size (in bytes)'),
        );
    }

    public function getEditableParams()
    {
        return array(
            'uploadPath',
            'allowedExtensions',
            'minSize',
            'maxSize',
            'mainCategory' => CHtml::listData($this->getCategoryList(),'id','name'),
        );
    }

    public function createUploadDir()
    {
        $current = '/' . date('Y/m/d');
        $dirName = $this->getUploadPath() . $current;

        if (is_dir($dirName))
            return $current;

        return @mkdir($dirName, 0700, true) ? $current : false;
    }

    public function checkSelf()
    {
        $messages = array();

        if (!$this->uploadPath)
             $messages[WebModule::CHECK_ERROR][] = array(
                'type'    => WebModule::CHECK_ERROR,
                'message' => Yii::t('ImageModule.image', 'Please, choose catalog for images! {link}', array(
                    '{link}' => CHtml::link(Yii::t('ImageModule.image', 'Change module settings'), array(
                        '/yupe/backend/modulesettings/',
                        'module' => $this->id,
                     )),
                )),
            );

        if (!is_dir($this->getUploadPath()) || !is_writable($this->getUploadPath()))
            $messages[WebModule::CHECK_ERROR][] = array(
                'type'    => WebModule::CHECK_ERROR,
                'message' => Yii::t('ImageModule.image', 'Directory "{dir}" is not accessible for writing ot not exists! {link}', array(
                    '{dir}' => $this->getUploadPath(),
                    '{link}' => CHtml::link(Yii::t('ImageModule.image', 'Change module settings'), array(
                        '/yupe/backend/modulesettings/',
                        'module' => $this->id,
                    )),
                )),
            );

        if (!$this->maxSize || $this->maxSize <= 0)
            $messages[WebModule::CHECK_ERROR][] = array(
                'type'    => WebModule::CHECK_ERROR,
                'message' => Yii::t('ImageModule.image', 'Set maximum images size {link}', array(
                    '{link}' => CHtml::link(Yii::t('ImageModule.image', 'Change module settings'), array(
                        '/yupe/backend/modulesettings/',
                        'module' => $this->id,
                     )),
                 )),
            );
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

        if (Yii::app()->hasModule('gallery'))
            $forImport[] = 'gallery.models.*';

        $this->setImport(
            array_merge(
                array(
                    'image.models.*'                  
                ), $forImport
            )
        );
    }  

    public function getNavigation()
    {
        return array(
            array('icon' => 'list-alt', 'label' => Yii::t('ImageModule.image', 'Images list'), 'url' => array('/image/imageBackend/index')),
            array('icon' => 'plus-sign', 'label' => Yii::t('ImageModule.image', 'Add image'), 'url' => array('/image/imageBackend/create')),
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
}