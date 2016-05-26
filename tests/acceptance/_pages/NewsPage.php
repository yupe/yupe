<?php
namespace tests\acceptance\pages;

class NewsPage
{
    const URL = '/news';
    const CATEGORIES_URL = '/news/categories';

    public static function route($alias)
    {
        return static::URL . '/' . $alias;
    }
}
