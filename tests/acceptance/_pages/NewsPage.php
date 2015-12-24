<?php
namespace tests\acceptance\pages;

class NewsPage
{
    const URL = '/news';

    public static function route($alias)
    {
        return static::URL . '/' . $alias;
    }
}
