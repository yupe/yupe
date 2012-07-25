<?php

class CatalogModule extends YWebModule
{

    public function getParamsLabels()
    {
        return array(
            'adminMenuOrder' => Yii::t('news', 'Порядок следования в меню'),
        );
    }

    public function getNavigation()
    {
        return array(
            Yii::t('catalog','Список товаров') => '/catalog/default/',
            Yii::t('catalog','Добавить товар') => '/catalog/default/create/'
        );
    }

    public function getAdminPageLink()
    {
        return '/catalog/default/';
    }

    public function getEditableParams()
    {
        return array(
            'adminMenuOrder',
        );
    }

    public function getVersion()
    {
        return '0.1 (dev)';
    }

    public function getCategory()
    {
        return Yii::t('catalog', 'Контент');
    }

    public function getName()
    {
        return Yii::t('catalog', 'Каталог товаров');
    }

    public function getDescription()
    {
        return Yii::t('catalog', 'Модуль для создания простого каталога товаров');
    }

    public function getAuthor()
    {
        return Yii::t('catalog', 'yupe team');
    }

    public function getAuthorEmail()
    {
        return Yii::t('catalog', 'team@yupe.ru');
    }

    public function getUrl()
    {
        return Yii::t('catalog', 'http://yupe.ru');
    }

    public function getIcon()
    {
        return "camera";
    }

    public function init()
    {
        parent::init();

        $this->setImport(array(
            'catalog.models.*',
            'catalog.components.*',
            'category.models.*'
        ));
    }

}
