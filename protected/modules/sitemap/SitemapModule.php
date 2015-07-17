<?php

use yupe\components\WebModule;

class SitemapModule extends WebModule
{
    public $data;

    public $filePath = 'sitemap.xml';

    const VERSION = '0.9.7';

    public function getSiteMapPath()
    {
        return Yii::getPathOfAlias('webroot') . '/' . $this->filePath;
    }

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
        return 'fa fa-fw fa-cog';
    }

    public function getCategory()
    {
        return Yii::t('SitemapModule.sitemap', 'Services');
    }

    public function getEditableParams()
    {
        return [
            'cacheTime'
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
        return self::VERSION;
    }

    public function init()
    {
        parent::init();

        $this->setImport(
            [
                'sitemap.components.*',
                'sitemap.events.*',
                'sitemap.models.*'
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

    public function getAuthItems()
    {
        return [
            [
                'name' => 'SitemapModule.SitemapManage',
                'description' => Yii::t('SitemapModule.sitemap', 'Manage sitemap'),
                'type' => AuthItem::TYPE_TASK,
                'items' => [
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'SitemapModule.SitemapBackend.manage',
                        'description' => Yii::t('SitemapModule.sitemap', 'Manage sitemap')
                    ]
                ]
            ]
        ];
    }
}
