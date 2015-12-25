<?php
namespace tests\acceptance\news;

use \WebGuy;
use tests\acceptance\pages\NewsPage;
use tests\acceptance\pages\CommonPage;
use tests\acceptance\user\steps\UserSteps;

class NewsShowCest
{
    public function tryToTestNewsPage(WebGuy $I, $scenario)
    {
        $I->am('anonymous user');
        $I->amGoingTo('test show news page...');
        $I->amOnPage(NewsPage::route('pervaja-opublikovannaja-novost'));
        $I->expectTo('see published news...');
        $I->see('Первая опубликованная новость', 'h4');
        $I->see('Первая опубликованная текст');
        $I->seeInTitle('Первая опубликованная новость');

        $I->amGoingTo('test show not published news...');
        $I->amOnPage(NewsPage::route('vtoraja-ne-opublikovannaja-novost'));
        $I->expectTo(' see page not found exception...');
        $I->dontSee('Вторая не опубликованная новость');
        $I->dontSeeInTitle('Вторая не опубликованная новость');

        $I->amGoingTo('test show protected news...');
        $I->amOnPage(NewsPage::route('tretja-novost-tolko-dlja-avtorizovannyh'));
        $I->expectTo(' see login page...');
        $I->dontSee('Третья новость только для авторизованных');
        $I->dontSee('Третья новость только для авторизованных текст');
        $I->dontSeeInTitle('Третья новость только для авторизованных текст');
        $I->seeInCurrentUrl('login');
        $I->see('Для просмотра этой страницы Вам необходимо авторизоваться!', CommonPage::ERROR_CSS_CLASS);

        $I->am('authorized user');
        $I = new UserSteps($scenario);
        $I->login('yupe@yupe.local', 'testpassword');
        $I->amGoingTo('test show protected news for authorized user...');
        $I->amOnPage(NewsPage::route('tretja-novost-tolko-dlja-avtorizovannyh'));
        $I->expectTo(' see protected news...');
        $I->see('Третья новость только для авторизованных', 'h4');
        $I->see('Третья новость только для авторизованных текст');
        $I->seeInTitle('Третья новость только для авторизованных');

        $I->amGoingTo('test show not published news...');
        $I->amOnPage(NewsPage::route('vtoraja-ne-opublikovannaja-novost'));
        $I->expectTo(' see page not found exception...');
        $I->dontSee('Вторая не опубликованная новость');
        $I->dontSeeInTitle('Вторая не опубликованная новость');
    }
}
