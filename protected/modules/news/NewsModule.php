<?php
class NewsModule extends YWebModule
{
    public $editor = 'application.modules.yupe.widgets.editors.imperaviRedactor.EImperaviRedactorWidget';

    public function getParamsLabels()
    {
        return array(
            'adminMenuOrder' => Yii::t('news', 'Порядок следования в меню'),
            'editor'         => Yii::t('page','Визуальный редактор') 
        );
    }

    public function getEditableParams()
    {
        return array(
            'adminMenuOrder',
            'editor' => Yii::app()->getModule('yupe')->getEditors()
        );
    }

    public  function getVersion()
    {
        return '0.2';
    }

    public function getCategory()
    {
        return Yii::t('news', 'Контент');
    }
    
    public function getName()
    {
        return Yii::t('news', 'Новости');
    }

    public function getDescription()
    {
        return Yii::t('news', 'Модуль для создания и публикации новостей');
    }

    public function getAuthor()
    {
        return Yii::t('news', 'yupe team');
    }

    public function getAuthorEmail()
    {
        return Yii::t('news', 'team@yupe.ru');
    }

    public function getUrl()
    {
        return Yii::t('news', 'http://yupe.ru');
    }

    public function init()
    {
        parent::init();

        $this->setImport(array(
                              'news.models.*',
                              'news.components.*',
                         ));
    }
}