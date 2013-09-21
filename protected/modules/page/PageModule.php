<?php

class PageModule extends yupe\components\WebModule
{
    public $mainCategory;

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
        return Yii::t('PageModule.page', '0.4.1');
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
              'application.modules.page.components.*',
              'application.modules.page.components.widgets.*',
         ));

        // Если у модуля не задан редактор - спросим у ядра
        if (!$this->editor)
            $this->editor = Yii::app()->getModule('yupe')->editor;
    }

    public function isMultiLang()
    {
        return true;
    }

    public function getCategoryList()
    {
        $criteria = array('order' => 'id ASC');
        if ($this->mainCategory)
            $criteria += array(
                'condition' => 'id = :id OR parent_id = :id',
                'params'    => array(':id' => $this->mainCategory),
            );
        return Category::model()->findAll($criteria);
    }

    public function getNavigation()
    {
        return array(
            array('icon' => 'list-alt', 'label' => Yii::t('PageModule.page', 'Pages list'), 'url' => array('/page/default/index')),
            array('icon' => 'plus-sign', 'label' => Yii::t('PageModule.page', 'Create page'), 'url' => array('/page/default/create')),
        );
    }
}