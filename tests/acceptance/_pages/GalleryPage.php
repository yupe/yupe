<?php
namespace tests\acceptance\pages;

class GalleryPage
{
    const ALBUMS_URL = '/albums';

    public static function getImageUrl($id)
    {
        return "/images/{$id}";
    }

}
