<?php
namespace tests\acceptance\store;

use \WebGuy;
use Facebook\WebDriver\WebDriverKeys;
use tests\acceptance\pages\CommonPage;
use tests\acceptance\user\steps\UserSteps;

class StoreLinkCest
{
    const BACKEND_LINK_PATH = '/backend/store/link/typeIndex';
    const BACKEND_LINK_DELETE_PATH = '/backend/store/link/typeDelete/3';

    public function tryToTestProductLinkTypes(WebGuy $I, $scenario)
    {
        $I = new UserSteps($scenario);
        $I->loginAsAdminAndGoToThePanel(CommonPage::TEST_USER_NAME, CommonPage::TEST_PASSWORD);
        $I->am('administrator');

        $I->amGoingTo('test backend product link types list');
        $I->amOnPage(self::BACKEND_LINK_PATH);
        $I->see('Типы связей', 'h1');
        $I->see('Добавить', '.btn-default');
        $I->seeLink('Управление типами связей');
        $I->see('Код', '.sort-link');
        $I->see('Название', '.sort-link');
        $I->seeInPageSource('<a class="delete" title="" data-toggle="tooltip" href="/index-test.php/backend/store/link/typeDelete/1" data-original-title="Удалить"');

        $I->amGoingTo('test grid filter');
        $I->fillField('//*[@id="question-grid"]/table/thead/tr[2]/td[2]/div/*[@id="ProductLinkType_code"]', 'similar');
        $I->pressKey('//*[@id="question-grid"]/table/thead/tr[2]/td[2]/div/*[@id="ProductLinkType_code"]', WebDriverKeys::ENTER);
        $I->wait(1);
        $I->seeLink('Похожие товары');
        $I->dontSeeLink('С этим товаром покупают');
        $I->fillField('//*[@id="question-grid"]/table/thead/tr[2]/td[2]/div/*[@id="ProductLinkType_code"]', '');
        $I->wait(1);
        $I->fillField('//*[@id="question-grid"]/table/thead/tr[2]/td[3]/div/*[@id="ProductLinkType_title"]', 'этим');
        $I->pressKey('//*[@id="question-grid"]/table/thead/tr[2]/td[3]/div/*[@id="ProductLinkType_title"]', WebDriverKeys::ENTER);
        $I->wait(1);
        $I->seeLink('С этим товаром покупают');
        $I->dontSeeLink('Похожие товары');
        $I->fillField('//*[@id="question-grid"]/table/thead/tr[2]/td[3]/div/*[@id="ProductLinkType_title"]', '');
        $I->wait(1);

        $I->amGoingTo('add a new link');
        $I->click('//*[@id="content"]/p/a[@class="btn btn-default btn-sm dropdown-toggle"]');
        $I->seeElement('//*[@id="question-form"]/div[2]/div[1]/div/*[@id="ProductLinkType_code"]');
        $I->seeElement('//*[@id="question-form"]/div[2]/div[2]/div/*[@id="ProductLinkType_title"]');
        $I->see('Добавить', '.btn-primary');
        $I->expectTo('see validation errors');
        $I->click('//*[@id="question-form"]/div[3]/div/*[@class="btn btn-primary"]');
        $I->see('Необходимо заполнить поле «Код»', '.error');
        $I->see('Необходимо заполнить поле «Название»', '.error');
        $I->fillField('//*[@id="question-form"]/div[2]/div[1]/div/*[@id="ProductLinkType_code"]', 'test');
        $I->fillField('//*[@id="question-form"]/div[2]/div[2]/div/*[@id="ProductLinkType_title"]', 'Тестовая связь');
        $I->click('//*[@id="question-form"]/div[3]/div/*[@class="btn btn-primary"]');
        $I->wait(1);
        $I->see('Запись добавлена!', '.alert-success');
        $I->seeLink('Тестовая связь');
        $I->dontSeeElement('//*[@id="question-form"]/div[2]/div[1]/div/*[@id="ProductLinkType_code"]');
        $I->dontSeeElement('//*[@id="question-form"]/div[2]/div[2]/div/*[@id="ProductLinkType_title"]');

        $I->amGoingTo('test deleting link');
        $I->amOnPage(self::BACKEND_LINK_DELETE_PATH);
        $I->expectTo('see an error message');
        $I->see('Неверный запрос. Пожалуйста, больше не повторяйте такие запросы!', '.alert-danger');
        $I->amOnPage(self::BACKEND_LINK_PATH);
        $I->expectTo('delete attr via ajax request');
        $I->executeJS('
            var url = document.location.href;
            $.post(
                url.replace("typeIndex", "typeDelete") + "/3", 
                {"YUPE_TOKEN":yupeToken}
            );
        ');
        $I->wait(1);
        $I->reloadPage();
        $I->dontSeeLink('Тестовая связь');
    }
}