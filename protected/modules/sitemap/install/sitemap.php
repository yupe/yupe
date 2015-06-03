<?php

return [
    'module' => [
        'class' => 'application.modules.sitemap.SitemapModule',
        'data' => [
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
            'blog' => [
                'Blog' => [
                    'getUrl' => function ($model) {
                            return $model->getAbsoluteUrl();
                        },
                    'getDataProvider' => function () {
                            return new CActiveDataProvider(CActiveRecord::model('Blog')->published(), []);
                        },
                    'getLastMod' => function ($model) {
                            return date('d-m-Y H:i', $model->update_time);
                        },
                    'changeFreq' => SitemapHelper::FREQUENCY_WEEKLY,
                    'priority' => 0.5,
                ],
                'Post' => [
                    'getUrl' => function ($model) {
                            return $model->getAbsoluteUrl();
                        },
                    'getDataProvider' => function () {
                            return new CActiveDataProvider(CActiveRecord::model('Post')->published(), []);
                        },
                    'getLastMod' => function ($model) {
                            return date('d-m-Y H:i', $model->update_time);
                        },
                    'changeFreq' => SitemapHelper::FREQUENCY_WEEKLY,
                    'priority' => 0.5,
                ]
            ],
        ]
    ],
    'import' => [],
    'component' => [],
    'rules' => [
        'sitemap.xml' => 'sitemap/sitemap/index',
        'sitemap/sitemap<number:\d+>.xml' => 'sitemap/sitemap/part',
    ],
];
