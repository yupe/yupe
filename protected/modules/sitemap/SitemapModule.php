<?php

use yupe\components\WebModule;

/**
 * Class SitemapModule
 */
class SitemapModule extends WebModule
{
    /**
     * @var
     */
    public $data;

    /**
     * @var string
     */
    public $filePath = 'sitemap.xml';

    /**
     *
     */
    const VERSION = '0.9.9';

    /**
     * @return string
     */
    public function getSiteMapPath()
    {
        return Yii::getPathOfAlias('webroot').'/'.$this->filePath;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return Yii::t('SitemapModule.sitemap', 'Sitemap');
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return Yii::t('SitemapModule.sitemap', 'Module for management sitemap.xml');
    }

    /**
     * @return string
     */
    public function getIcon()
    {
        return 'fa fa-fw fa-cog';
    }

    /**
     * @return string
     */
    public function getCategory()
    {
        return Yii::t('SitemapModule.sitemap', 'Services');
    }

    /**
     * @return array
     */
    public function getEditableParams()
    {
        return [
            'cacheTime',
        ];
    }

    /**
     * @return array
     */
    public function getParamsLabels()
    {
        return [
            'cacheTime' => Yii::t('SitemapModule.sitemap', 'The cache sitemap in hours'),
        ];
    }

    /**
     * @return string
     */
    public function getVersion()
    {
        return self::VERSION;
    }

    /**
     *
     */
    public function init()
    {
        parent::init();

        $this->setImport(
            [
                'sitemap.components.*',
                'sitemap.events.*',
                'sitemap.models.*',
            ]
        );
    }

    /**
     * @return mixed
     */
    public function getSettingsUrl()
    {
        return Yii::app()->createUrl('/sitemap/sitemapBackend/settings');
    }

    /**
     * @return string
     */
    public function getAdminPageLink()
    {
        return '/sitemap/sitemapBackend/settings';
    }

    /**
     * @return array
     */
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
                        'description' => Yii::t('SitemapModule.sitemap', 'Manage sitemap'),
                    ],
                ],
            ],
        ];
    }
}
