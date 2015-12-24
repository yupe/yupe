<?php
namespace tests\acceptance\gallery;

use \WebGuy;
use tests\acceptance\pages\GalleryPage;

class GalleryViewCest
{
    public function tryTestGalleryViews(WebGuy $I, $scenario)
    {
        $I->am('simple user');
        $I->amOnPage(GalleryPage::ALBUMS_URL);
        $I->see('Галереи изображений');
        $I->seeLink('Первая галерея');
        $I->see('Всего изображений');
        $I->see('08 ноября 2013 г., 01:21');

        $I->amOnPage(GalleryPage::ALBUMS_URL . '/1');
        $I->see('Первая галерея', 'h1');
        $I->seeInCurrentUrl(GalleryPage::ALBUMS_URL . '/1');

        $I->see('2013-10-22 22.33.28.jpg');
        $I->see('Подробнее...');
        $I->click('Подробнее...');

        $I->seeInCurrentUrl(GalleryPage::getImageUrl(1));
        $I->see('2013-10-22 22.33.28.jpg');
        $I->see('Станьте первым!');
        $I->see('08 ноября 2013 г., 01:21');
    }
}
