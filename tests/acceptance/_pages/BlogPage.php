<?php
namespace tests\acceptance\pages;

class BlogPage
{
    const BLOGS_URL = '/blogs';

    const PUBLIC_BLOG_SLUG = 'public-blog';

    const DELETED_BLOG_SLUG = 'deleted-blog';

    public static function getBlogRoute($blog)
    {
        return self::BLOGS_URL . '/' . $blog;
    }
}
