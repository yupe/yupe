<?php
namespace tests\acceptance\news;

use \WebGuy;
use tests\acceptance\pages\NewsPage;
use tests\acceptance\pages\CommonPage;
use tests\acceptance\user\steps\UserSteps;

class NewsPublishCest
{
    public function tryToTestPagePublishing(WebGuy $I, $scenario)
    {
        $I = new UserSteps($scenario);
        $I->login(CommonPage::TEST_USER_NAME, CommonPage::TEST_PASSWORD);
        $I->am('admin');
        $I->amGoingTo('test publishing news...');
        $I->amOnPage(CommonPage::PANEL_URL);
        $I->see(CommonPage::PANEL_LABEL, 'h1');
        $I->amOnPage('/backend/news/news');
        $I->see('Новости');
        $I->seeLink('Вторая не опубликованная новость');
        $I->amOnPage(CommonPage::PANEL_URL . 'news/news/update/2');
        $I->see('Редактирование новости');
        $I->see('Вторая не опубликованная новость');
        $I->selectOption('News[status]', 'Опубликовано');
        $I->click('Сохранить новость и продолжить');
        $I->see('Новость обновлена!', CommonPage::SUCCESS_CSS_CLASS);

        $I->logout();
        $I->am('anonymous user');
        $I->amGoingTo('test show just published news...');
        $I->amOnPage(NewsPage::route('vtoraja-ne-opublikovannaja-novost'));
        $I->expectTo('see just published news...');
        $I->see('Вторая не опубликованная новость', 'h4');
        $I->see('Вторая не опубликованная новость текст');
        $I->seeInTitle('Вторая не опубликованная новость');
    }
}
