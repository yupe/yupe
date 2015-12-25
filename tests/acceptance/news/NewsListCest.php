<?php
namespace tests\acceptance\news;

use \WebGuy;
use tests\acceptance\pages\NewsPage;
use tests\acceptance\user\steps\UserSteps;

class NewsListCest
{
    public function tryToTestNewsListPage(WebGuy $I, $scenario)
    {
        $I->am('simple user');
        $I->amGoingTo('test news list page...');
        $I->amOnPage(NewsPage::URL);
        $I->see('Новости', 'h1');
        $I->seeLink('Первая опубликованная новость');
        $I->dontSeeLink('Третья новость только для авторизованных');
        $I->dontSeeLink('Вторая не опубликованная новость');

        $I->am('authorized user');
        $I = new UserSteps($scenario);
        $I->login('yupe@yupe.local', 'testpassword');
        $I->amGoingTo('test news list for authorized user...');
        $I->amOnPage(NewsPage::URL);
        $I->expectTo('see news list with protected news...');
        $I->seeLink('Первая опубликованная новость');
        $I->seeLink('Третья новость только для авторизованных');
        $I->dontSeeLink('Вторая не опубликованная новость');
    }
}
