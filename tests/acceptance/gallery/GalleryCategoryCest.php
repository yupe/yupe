<?php
namespace tests\acceptance\gallery;

use \WebGuy;
use tests\acceptance\pages\GalleryPage;

class GalleryCategoryCest
{
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
