<?php
namespace tests\acceptance\page;

use \WebGuy;
use tests\acceptance\pages\LoginPage;
use tests\acceptance\pages\CommonPage;
use tests\acceptance\user\steps\UserSteps;

class PageViewCest
{ // tests
    public function tryToTest(WebGuy $I, $scenario)
    {
        $I->wantToTest('show published page...');
        $I->amOnPage('/pages/opublikovannaja-starnica');
        $I->seeInTitle('Опубликованная страница');
        $I->see('Опубликованная страница', 'h1');
        $I->see('Опубликованная страница текст');

        $I->wantToTest('unpublished page...');
        $I->amOnPage('/pages/skrytaja-stranica');
        $I->see('Страница которую вы запросили не найдена.');

        $I->wantToTest('protected page...');
        $I->amOnPage('/pages/zaschischennaja-stranica');
        $I->seeInCurrentUrl(LoginPage::$URL);
        $I->see('Для просмотра этой страницы Вам необходимо авторизоваться!', CommonPage::ERROR_CSS_CLASS);

        $I = new UserSteps($scenario);
        $I->login('yupe@yupe.local', 'testpassword');
        $I->amOnPage('/pages/zaschischennaja-stranica');
        $I->seeInTitle('Защищенная страница');
        $I->see('Защищенная страница', 'h1');
        $I->see('Защищенная страница текст');

        $I->wantToTest('page preview...');
        $I->amOnPage('/pages/skrytaja-stranica');
        $I->see('Страница которую вы запросили не найдена.');
        $I->amOnPage('/pages/skrytaja-stranica?preview=1');
        $I->seeInTitle('Скрытая страница');
        $I->see('Скрытая страница', 'h1');
        $I->see('Скрытая страница текст');
    }

}
