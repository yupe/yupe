<?php

class PageModule extends YWebModule
{
    public $editor = 'application.modules.yupe.widgets.editors.imperaviRedactor.EImperaviRedactorWidget';

    public $mainCategory;

    public function getParamsLabels()
    {
        return array(
            'mainCategory'   => Yii::t('news','Главная категория страниц'),
            'adminMenuOrder' => Yii::t('page','Порядок следования в меню'),
            'editor'         => Yii::t('page','Визуальный редактор')
        );
    }

    public function  getVersion()
    {
        return '0.3';
    }

    public function getEditableParams()
    {
        return array(
            'adminMenuOrder',
            'editor' => Yii::app()->getModule('yupe')->getEditors(),
            'mainCategory' => CHtml::listData(Category::model()->findAll(),'id','name'),
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
        if ( !$this->editor )
            $this->editor=Yii::app()->getModule('yupe')->editor;
    }

    public function isMultiLang()
    {
        return true;
    }

    public function getCategoryList()
    {
        $criteria = array();

        if($this->mainCategory)
            $criteria = array(
                'condition' => 'id = :id OR parent_id = :id',
                'params'    => array(':id' => $this->mainCategory),
                'order'     => 'id ASC',
            );

        return Category::model()->findAll($criteria);
    }

    public function getNavigation()
    {
        return array(
            array('icon' => 'plus-sign', 'label' => Yii::t('page', 'Добавить страницу'), 'url' => array('/page/default/create/')),
            array('icon' => 'th-list', 'label' => Yii::t('page', 'Список страниц'), 'url' => array('/page/default/admin/')),
        );
    }
}