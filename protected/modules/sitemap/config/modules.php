<?php

return [
    'page' => [
        'Page' => [
            'getUrl' => function ($model) {
                return $model->getUrl(true);
            },
            'getDataProvider' => function () {
                return new CActiveDataProvider(CActiveRecord::model('page')->published(), []);
            },
            'getLastMod' => function ($model) {
                return $model->change_date;
            },
        ]
    ],
    'news' => [
        'News' => [
            'getUrl' => function ($model) {
                return Yii::app()->createAbsoluteUrl('news/news/show', ['alias' => $model->alias]);
            },
            'getDataProvider' => function () {
                return new CActiveDataProvider(CActiveRecord::model('news')->published(), []);
            },
            'getLastMod' => function ($model) {
                return $model->change_date;
            },
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
        ]
    ],
];
