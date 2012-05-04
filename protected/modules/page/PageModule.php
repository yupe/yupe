<?php

class PageModule extends YWebModule
{
    public $editor = 'application.modules.yupe.widgets.editors.imperaviRedactor.EImperaviRedactorWidget';

    public function getParamsLabels()
    {
        return array(
            'adminMenuOrder' => Yii::t('page','Порядок следования в меню'),
            'editor'         => Yii::t('page','Визуальный редактор')
        );
    }

    public function  getVersion()
    {
        return '0.2';
    }

    public function getEditableParams()
    {
        return array(
            'adminMenuOrder',
            'editor' => Yii::app()->getModule('yupe')->getEditors()
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
}