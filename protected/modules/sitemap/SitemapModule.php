<?php

use yupe\components\WebModule;

class SitemapModule extends WebModule
{
    /**
     * @var int - Время кеширования sitemap в часах
     */
    public $cacheTime = 12;

    public function getDependencies()
    {
        return array();
    }

    public function getEditableParams()
    {
        return array(
            'cacheTime',
        );
    }

    public function getParamsLabels()
    {
        return array(
            'cacheTime' => Yii::t('SitemapModule.sitemap', 'Время кеширования sitemap в часах'),
        );
    }

    public function getNavigation()
    {
        return array(

        );
    }

    public function getAdminPageLink()
    {
        return '/backend/modulesettings/sitemap';
    }

    public function getVersion()
    {
        return '0.1';
    }

    public function getCategory()
    {

    }

    public function getName()
    {
        return Yii::t('SitemapModule.sitemap', 'Sitemap');
    }

    public function getDescription()
    {
        return Yii::t('SitemapModule.sitemap', 'Модуль для создания sitemap.xml');
    }

    public function getAuthor()
    {
        return Yii::t('SitemapModule.sitemap', 'Dark_Cs');
    }

    public function getAuthorEmail()
    {
        return Yii::t('SitemapModule.sitemap', 'darkcs2@gmail.com');
    }

    public function getUrl()
    {
        return 'http://migsite.ru';
    }

    public function getIcon()
    {
        return 'cog';
    }

    public function init()
    {
        parent::init();

        $this->setImport(array(
            'sitemap.components.*',
        ));
    }
}