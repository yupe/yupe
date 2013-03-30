<?php

class PageModule extends YWebModule
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
            'adminMenuOrder' => Yii::t('PageModule.page', 'Порядок следования в меню'),
            'editor'         => Yii::t('PageModule.page', 'Визуальный редактор'),
            'mainCategory'   => Yii::t('PageModule.page', 'Главная категория страниц'),
        );
    }

    public function  getVersion()
    {
        return Yii::t('PageModule.page', '0.4');
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
        return Yii::t('PageModule.page', 'Контент');
    }

    public function getName()
    {
        return Yii::t('PageModule.page', 'Страницы');
    }

    public function getDescription()
    {
        return Yii::t('PageModule.page', 'Модуль для создания и редактирования страничек сайта');
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
            array('icon' => 'list-alt', 'label' => Yii::t('PageModule.page', 'Список страниц'), 'url' => array('/page/default/index')),
            array('icon' => 'plus-sign', 'label' => Yii::t('PageModule.page', 'Добавить страницу'), 'url' => array('/page/default/create')),
        );
    }
}