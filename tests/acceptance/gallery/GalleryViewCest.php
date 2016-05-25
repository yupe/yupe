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
        $I->seeLink('Вторая галерея');
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

    public function tryTestGalleryCategories(WebGuy $I, $scenario)
    {
        $I->amOnPage(GalleryPage::CATEGORIES_URL);
        $I->see('Категории галерей', 'h1');
        $I->seeLink('Галереи. Первая категория');
        $I->seeLink('Галереи. Вторая категория');

        $I->click('Галереи. Первая категория');
        $I->see('Галереи. Первая категория', 'h1');
        $I->seeLink('Первая галерея');
        $I->seeLink('Категории галерей');
        $I->dontSeeLink('Вторая галерея');
        $I->click('Категории галерей');

        $I->seeInCurrentUrl(GalleryPage::CATEGORIES_URL);
        $I->click('Галереи. Вторая категория');
        $I->see('Галереи. Вторая категория', 'h1');
        $I->seeLink('Вторая галерея');
        $I->dontSeeLink('Первая галерея');

    }
}
