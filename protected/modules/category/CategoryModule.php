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

class CategoryModule extends WebModule
{
    public $uploadPath = 'category';

    public function getUploadPath()
    {
        return Yii::getPathOfAlias('webroot') . '/' . Yii::app()->getModule('yupe')->uploadPath . '/' . $this->uploadPath . '/';
    }

    public function checkSelf()
    {
        $messages = array();

        $uploadPath = $this->getUploadPath();

        if (!is_writable($uploadPath))
            $messages[WebModule::CHECK_ERROR][] = array(
                'type'    => WebModule::CHECK_ERROR,
                'message' => Yii::t('CategoryModule.category', 'Directory "{dir}" is available for write! {link}', array(
                    '{dir}'  => $uploadPath,
                    '{link}' => CHtml::link(Yii::t('CategoryModule.category', 'Change settings'), array(
                        '/yupe/backend/modulesettings/',
                        'module' => 'category',
                    )),
                )),
            );

        return isset($messages[WebModule::CHECK_ERROR]) ? $messages : true;
    }

    public function getInstall()
    {
        if(parent::getInstall()){
            @mkdir($this->getUploadPath(),0755);
        }

        return false;
    }

    public function getEditableParams()
    {
        return array(
            'adminMenuOrder',
            'uploadPath',
        );
    }

    public function getParamsLabels()
    {
        return array(
            'adminMenuOrder' => Yii::t('CategoryModule.category', 'Menu items order'),
            'uploadPath'     => Yii::t('CategoryModule.category', 'File uploading catalog (relatively Yii::app()->getModule("yupe")->uploadPath)'),
        );
    }

    public function getIsInstallDefault()
    {
        return true;
    }

    public function getVersion()
    {
        return Yii::t('CategoryModule.category', '0.6');
    }

    public function getCategory()
    {
        return Yii::t('CategoryModule.category', 'Structure');
    }

    public function getName()
    {
        return Yii::t('CategoryModule.category', 'Categories/Sections');
    }

    public function getDescription()
    {
        return Yii::t('CategoryModule.category', 'Module for categories/sections management');
    }

    public function getAuthor()
    {
        return Yii::t('CategoryModule.category', 'yupe team');
    }

    public function getAuthorEmail()
    {
        return Yii::t('CategoryModule.category', 'team@yupe.ru');
    }

    public function getUrl()
    {
        return Yii::t('CategoryModule.category', 'http://yupe.ru');
    }

    public function getIcon()
    {
        return 'folder-open';
    }

    public function isMultiLang()
    {
        return true;
    }

    public function init()
    {
        parent::init();

        $this->setImport(array(
            'category.models.*',
            'category.components.*',
        ));
    }

    public function getNavigation()
    {
        return array(
            array('icon' => 'list-alt', 'label' => Yii::t('CategoryModule.category', 'Categories list'), 'url' => array('/category/categoryBackend/index')),
            array('icon' => 'plus-sign', 'label' => Yii::t('CategoryModule.category', 'Create category'), 'url' => array('/category/categoryBackend/create')),
        );
    }

    public function getAdminPageLink()
    {
        return '/category/categoryBackend/index';
    }
}