<?php

return array(
    array(
        'module' => 'page',
        'model' => 'Page',
        'changefreq' => SitemapHelper::WEEKLY,
        'priority' => 0.5,
        'getUrlFunction' => function ($model)
            {
                return Yii::app()->createAbsoluteUrl('page/page/show', array('slug' => $model->slug));
            },
        'lastModAttribute' => 'change_date'
    ),
    array(
        'module' => 'news',
        'model' => 'News',
        'changefreq' => SitemapHelper::WEEKLY,
        'priority' => 0.5,
        'getUrlFunction' => function ($model)
            {
                return Yii::app()->createAbsoluteUrl('news/news/show', array('alias' => $model->alias));
            },
        'lastModAttribute' => 'change_date'
    ),
    array(
        'module' => 'catalog',
        'model' => 'Good',
        'changefreq' => SitemapHelper::WEEKLY,
        'priority' => 0.5,
        'getUrlFunction' => function ($model)
            {
                return Yii::app()->createAbsoluteUrl('catalog/catalog/show', array('name' => $model->alias));
            },
        'lastModAttribute' => 'update_time'
    ),
    array(
        'module' => 'shop',
        'model' => 'Product',
        'changefreq' => SitemapHelper::WEEKLY,
        'priority' => 0.5,
        'getUrlFunction' => function ($model)
            {
                return Yii::app()->createAbsoluteUrl('shop/product/show', array('name' => $model->alias));
            },
        'lastModAttribute' => 'update_time'
    ),
    array(
        'module' => 'shop',
        'model' => 'Category',
        'changefreq' => SitemapHelper::WEEKLY,
        'priority' => 0.5,
        'getUrlFunction' => function ($model)
            {
                return Yii::app()->request->hostInfo . $model->getUrl();
            },
        'lastModAttribute' => null
    ),
);