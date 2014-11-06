<?php

return [
    'page' => [
        'Page' => [
            'getUrl' => function ($model) {
                return $model->getUrl(true);
            },
            'getDataProvider' => function () {
                return new CActiveDataProvider(CActiveRecord::model('Page')->published(), []);
            },
            'getLastMod' => function ($model) {
                return $model->change_date;
            },
            'changeFreq' => SitemapHelper::FREQUENCY_WEEKLY,
            'priority' => 0.5,
        ]
    ],
    'news' => [
        'News' => [
            'getUrl' => function ($model) {
                return Yii::app()->createAbsoluteUrl('news/news/show', ['alias' => $model->alias]);
            },
            'getDataProvider' => function () {
                return new CActiveDataProvider(CActiveRecord::model('News')->published(), []);
            },
            'getLastMod' => function ($model) {
                return $model->change_date;
            },
            'changeFreq' => SitemapHelper::FREQUENCY_WEEKLY,
            'priority' => 0.5,
        ]
    ],
    'blog' => [
        'Blog' => [
            'getUrl' => function ($model) {
                return Yii::app()->createAbsoluteUrl('blog/blog/show', ['slug' => $model->slug]);
            },
            'getDataProvider' => function () {
                return new CActiveDataProvider(CActiveRecord::model('Blog')->published(), []);
            },
            'getLastMod' => function ($model) {
                return date('d-m-Y H:i', $model->update_date);
            },
            'changeFreq' => SitemapHelper::FREQUENCY_WEEKLY,
            'priority' => 0.5,
        ],
        'Post' => [
            'getUrl' => function ($model) {
                return Yii::app()->createAbsoluteUrl('blog/post/show', ['slug' => $model->slug]);
            },
            'getDataProvider' => function () {
                return new CActiveDataProvider(CActiveRecord::model('Post')->published(), []);
            },
            'getLastMod' => function ($model) {
                return date('d-m-Y H:i', $model->update_date);
            },
            'changeFreq' => SitemapHelper::FREQUENCY_WEEKLY,
            'priority' => 0.5,
        ]
    ],
];
