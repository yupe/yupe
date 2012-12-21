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
            'adminMenuOrder' => Yii::t('page', 'Порядок следования в меню'),
            'editor'         => Yii::t('page', 'Визуальный редактор'),
            'mainCategory'   => Yii::t('news', 'Главная категория страниц'),
        );
    }

    public function  getVersion()
    {
        return Yii::t('page', '0.3');
    }

    public function getEditableParams()
    {
        return array(
            'adminMenuOrder',
            'editor'        => Yii::app()->getModule('yupe')->editors,
            'mainCategory'  => Category::model()->allCategoryList,
        );
    }

    public function getCategory()
    {
        return Yii::t('page', 'Контент');
    }

    public function getName()
    {
        return Yii::t('page', 'Страницы');
    }

    public function getDescription()
    {
        return Yii::t('page', 'Модуль для создания и редактирования страничек сайта');
    }

    public function getAuthor()
    {
        return Yii::t('page', 'yupe team');
    }

    public function getAuthorEmail()
    {
        return Yii::t('page', 'team@yupe.ru');
    }

    public function getUrl()
    {
        return Yii::t('page', 'http://yupe.ru');
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
        $criteria = ($this->mainCategory)
            ? array(
                'condition' => 'id = :id OR parent_id = :id',
                'params'    => array(':id' => $this->mainCategory),
                'order'     => 'id ASC',
            )
            : array();

        return Category::model()->findAll($criteria);
    }

    public function getNavigation()
    {
        return array(
            array('icon' => 'list-alt', 'label' => Yii::t('page', 'Управление страницами'), 'url' => array('/page/default/index')),
            array('icon' => 'plus-sign', 'label' => Yii::t('page', 'Добавить страницу'), 'url' => array('/page/default/create')),
        );
    }
}