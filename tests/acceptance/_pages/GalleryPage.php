<?php
namespace tests\acceptance\pages;

class GalleryPage
{
    const ALBUMS_URL = '/albums';
    const CATEGORIES_URL = '/albums/categories';

    public static function getImageUrl($id)
    {
        return "/images/{$id}";
    }

}
