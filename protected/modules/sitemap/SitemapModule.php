<?php

use yupe\components\WebModule;

class SitemapModule extends WebModule
{
    /**
     * @var int - Время кеширования sitemap в часах
     */
    public $cacheTime = 12;

    public function getName()
    {
        return Yii::t('SitemapModule.sitemap', 'Sitemap');
    }

    public function getDescription()
    {
        return Yii::t('SitemapModule.sitemap', 'Module for management sitemap.xml');
    }

    public function getIcon()
    {
        return 'glyphicon glyphicon-cog';
    }

    public function getCategory()
    {
        return Yii::t('SitemapModule.sitemap', 'Services');
    }

    public function getEditableParams()
    {
        return [
            'cacheTime',
        ];
    }

    public function getParamsLabels()
    {
        return [
            'cacheTime' => Yii::t('SitemapModule.sitemap', 'The cache sitemap in hours'),
        ];
    }

    public function getVersion()
    {
        return '0.1';
    }

    public function init()
    {
        parent::init();

        $this->setImport(
            [
                'sitemap.components.*',
                'sitemap.models.*',
            ]
        );
    }

    public function getSettingsUrl()
    {
        return Yii::app()->createUrl('/sitemap/sitemapBackend/settings');
    }

    public function getAdminPageLink()
    {
        return '/sitemap/sitemapBackend/settings';
    }
}
