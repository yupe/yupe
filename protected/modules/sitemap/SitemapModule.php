<?php

use yupe\components\WebModule;

class SitemapModule extends WebModule
{
    /* $data =  [
    'page' => [
    'Page' => [
    'getUrl' => function ($model) {
        return $model->getAbsoluteUrl();
    },
    'getDataProvider' => function () {
        return new CActiveDataProvider(CActiveRecord::model('Page')->published(), []);
    },
    'getLastMod' => function ($model) {
        return $model->update_time;
    },
    'changeFreq' => SitemapHelper::FREQUENCY_WEEKLY,
    'priority' => 0.5,
    ]
    ],
    'news' => [
    'News' => [
    'getUrl' => function ($model) {
        return $model->getAbsoluteUrl();
    },
    'getDataProvider' => function () {
        return new CActiveDataProvider(CActiveRecord::model('News')->published(), []);
    },
    'getLastMod' => function ($model) {
        return $model->update_time;
    },
    'changeFreq' => SitemapHelper::FREQUENCY_WEEKLY,
    'priority' => 0.5,
    ]
    ],
        ]*/

    public $data;

    const VERSION = '0.9.7';
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
        return 'fa fa-fw fa-cog';
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
        return self::VERSION;
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
                    ],
                ]
            ]
        ];
    }
}
