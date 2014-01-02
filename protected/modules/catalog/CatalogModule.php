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
    public $uploadPath        = 'catalog';
    public $allowedExtensions = 'jpg,jpeg,png,gif';
    public $minSize           = 0;
    public $maxSize;
    public $maxFiles          = 1;

    public function getDependencies()
    {
        return array(
            'user',
            'category'
        );
    }

    public function getUploadPath()
    {
        return  Yii::getPathOfAlias('webroot') . '/' .
                Yii::app()->getModule('yupe')->uploadPath . '/' .
                $this->uploadPath . '/';
    }

    public function checkSelf()
    {
        $messages = array();

        $uploadPath = $this->getUploadPath();

        if (!is_writable($uploadPath))
            $messages[WebModule::CHECK_ERROR][] =  array(
                'type'    => WebModule::CHECK_ERROR,
                'message' => Yii::t('CatalogModule.catalog', 'Directory "{dir}" is not writeable! {link}', array(
                    '{dir}'  => $uploadPath,
                    '{link}' => CHtml::link(Yii::t('CatalogModule.catalog', 'Change settings'), array(
                        '/yupe/backend/modulesettings/',
                        'module' => 'catalog',
                    )),
                )),
            );

        return isset($messages[WebModule::CHECK_ERROR]) ? $messages : true;
    }

    public function getInstall()
    {
        if(parent::getInstall()) {
            @mkdir($this->getUploadPath(),0755);
        }

        return false;
    }

    public function getEditableParams()
    {
        return array(
            'mainCategory' => CHtml::listData($this->getCategoryList(),'id','name'),
            'uploadPath',
            'adminMenuOrder',
            'editor'       => Yii::app()->getModule('yupe')->editors,
            'allowedExtensions',
            'minSize',
            'maxSize',
        );
    }

    public function getParamsLabels()
    {
        return array(
            'mainCategory'      => Yii::t('CatalogModule.catalog', 'Main category of products'),
            'adminMenuOrder'    => Yii::t('CatalogModule.catalog', 'Menu items order'),
            'uploadPath'        => Yii::t('CatalogModule.catalog', 'File uploads directory (relative to Yii::app()->getModule("yupe")->uploadPath)'),
            'editor'            => Yii::t('CatalogModule.catalog', 'Visual editor'),
            'allowedExtensions' => Yii::t('CatalogModule.catalog', 'Accepted extensions (separated by comma)'),
            'minSize'           => Yii::t('CatalogModule.catalog', 'Minimum size (in bytes)'),
            'maxSize'           => Yii::t('CatalogModule.catalog', 'Maximum size (in bytes)'),
        );
    }

    public function getNavigation()
    {
        return array(
            array('icon' => 'list-alt', 'label' => Yii::t('CatalogModule.catalog', 'Product list'), 'url' => array('/catalog/catalogBackend/index')),
            array('icon' => 'plus-sign', 'label' => Yii::t('CatalogModule.catalog', 'Add a product'), 'url' => array('/catalog/catalogBackend/create')),
        );
    }

    public function getAdminPageLink()
    {
        return '/catalog/catalogBackend/index';
    }
    
    public function getVersion()
    {
        return '0.6';
    }

    public function getCategory()
    {
        return Yii::t('CatalogModule.catalog', 'Content');
    }

    public function getName()
    {
        return Yii::t('CatalogModule.catalog', 'Product catalog');
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
        return 'shopping-cart';
    }

    public function init()
    {
        parent::init();

        $this->setImport(array(
            'catalog.models.*',
            'catalog.components.*',
            //'category.models.*',
        ));
    }  
}