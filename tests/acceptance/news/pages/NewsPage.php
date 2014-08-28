<?php

class NewsPage
{
    const URL = '/news';

    public static function route($alias)
    {
        return static::URL . '/' . $alias;
    }
}
