<?php
/**
 * PageModule основной класс модуля page
 *
 * @author yupe team <team@yupe.ru>
 * @link http://yupe.ru
 * @copyright 2009-2013 amyLabs && Yupe! team
 * @package yupe.modules.page
 * @since 0.1
 *
 */

class PageModule extends yupe\components\WebModule
{
    public function getDependencies()
    {
        return array(
            'user',
            'category',
        );
    }

    public function getParamsLabels()
    {
        return array(
            'adminMenuOrder' => Yii::t('PageModule.page', 'Menu items order'),
            'editor'         => Yii::t('PageModule.page', 'Visual editor'),
            'mainCategory'   => Yii::t('PageModule.page', 'Main pages category'),
        );
    }

    public function  getVersion()
    {
        return Yii::t('PageModule.page', '0.6');
    }

    public function getEditableParams()
    {
        return array(
            'adminMenuOrder',
            'editor'        => Yii::app()->getModule('yupe')->editors,
            'mainCategory'  => CHtml::listData($this->getCategoryList(), 'id', 'name'),
        );
    }

    public function getIsInstallDefault()
    {
        return true;
    }

    public function getCategory()
    {
        return Yii::t('PageModule.page', 'Content');
    }

    public function getName()
    {
        return Yii::t('PageModule.page', 'Pages');
    }

    public function getDescription()
    {
        return Yii::t('PageModule.page', 'Module for creating and manage static pages');
    }

    public function getAuthor()
    {
        return Yii::t('PageModule.page', 'yupe team');
    }

    public function getAuthorEmail()
    {
        return Yii::t('PageModule.page', 'team@yupe.ru');
    }

    public function getUrl()
    {
        return Yii::t('PageModule.page', 'http://yupe.ru');
    }

    public function getIcon()
    {
        return "file";
    }

    public function init()
    {
        parent::init();

        $this->setImport(array(
              'application.modules.page.models.*',              
              'application.modules.page.components.widgets.*',
        ));

        // Если у модуля не задан редактор - спросим у ядра
        if (!$this->editor) {
            $this->editor = Yii::app()->getModule('yupe')->editor;
        }
    }

    public function isMultiLang()
    {
        return true;
    }   

    public function getAdminPageLink()
    {
        return '/page/pageBackend/index';
    }

    public function getNavigation()
    {
        return array(
            array('icon' => 'list-alt', 'label' => Yii::t('PageModule.page', 'Pages list'), 'url' => array('/page/pageBackend/index')),
            array('icon' => 'plus-sign', 'label' => Yii::t('PageModule.page', 'Create page'), 'url' => array('/page/pageBackend/create')),
        );
    }
}