<?php
namespace tests\acceptance\news;

use \WebGuy;
use tests\acceptance\pages\NewsPage;

class NewsCategoryCest
{
    public function tryTestNewsCategories(WebGuy $I, $scenario)
    {
        $I->amOnPage(NewsPage::CATEGORIES_URL);
        $I->see('Категории новостей', 'h1');
        $I->seeLink('Новости. Первая категория');
        $I->seeLink('Новости. Вторая категория');

        $I->click('Новости. Первая категория');
        $I->see('Новости категории "Новости. Первая категория"', 'h1');
        $I->seeLink('Категории новостей');
        $I->seeLink('Первая опубликованная новость');
        $I->dontSeeLink('Четвертая новость');
        $I->click('Категории новостей');

        $I->seeInCurrentUrl(NewsPage::CATEGORIES_URL);
        $I->click('Новости. Вторая категория');
        $I->see('Новости категории "Новости. Вторая категория"', 'h1');
        $I->seeLink('Четвертая новость');
        $I->dontSeeLink('Первая опубликованная новость');

    }
}