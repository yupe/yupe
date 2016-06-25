<?php
namespace tests\acceptance\store;

use \WebGuy;
use Facebook\WebDriver\WebDriverKeys;
use tests\acceptance\pages\CommonPage;
use tests\acceptance\user\steps\UserSteps;

class StoreTypeCest
{
    const BACKEND_TYPE_PATH = '/backend/store/type';

    public function tryToTestTypes(WebGuy $I, $scenario)
    {
        $I = new UserSteps($scenario);
        $I->loginAsAdminAndGoToThePanel(CommonPage::TEST_USER_NAME, CommonPage::TEST_PASSWORD);
        $I->am('administrator');

        $I->amGoingTo('test backend type list');
        $I->amOnPage(self::BACKEND_TYPE_PATH);
        $I->see('Типы товаров', 'h1');
        $I->expectTo('see sidebar menu');
        $I->seeLink('Управление типами');
        $I->seeLink('Добавить тип');
        $I->expectTo('see type list');
        $I->seeLink('Клавиатуры');
        $I->seeLink('Мониторы');
        $I->expectTo('see buttons column');
        $I->seeInPageSource('<a class="update btn btn-sm btn-default" title="" data-toggle="tooltip" href="/index-test.php/backend/store/type/update/1"');
        $I->seeInPageSource('<a class="delete btn btn-sm btn-default" title="" data-toggle="tooltip" href="/index-test.php/backend/store/type/delete/1"');

        $I->amGoingTo('test type grid filter');
        $I->fillField('Type[name]', 'Мон');
        $I->pressKey('#Type_name', WebDriverKeys::ENTER);
        $I->wait(1);
        $I->seeLink('Мониторы');
        $I->dontSeeLink('Клавиатуры');

        $I->amGoingTo('add a new type');
        $I->amOnPage(self::BACKEND_TYPE_PATH . '/create');
        $I->see('Тип товара', 'h1');
        $I->see('Группа1', 'label');
        $I->see('Группа2', 'label');
        $I->expectTo('see validation errors');
        $I->click('Добавить тип и закрыть');
        $I->see('Необходимо заполнить поле «Название»', '.error');
        $I->fillField('Type[name]', 'Телефны');
        $I->expectTo('see successful addition of data');
        $I->click('Добавить тип и закрыть');
        $I->wait(1);
        $I->seeInCurrentUrl(self::BACKEND_TYPE_PATH);
        $I->see('Тип товара создан', '.alert-success');
        $I->seeLink('Телефны');

        $I->amGoingTo('edit wrong type name');
        $I->amOnPage(self::BACKEND_TYPE_PATH . '/update/3');
        $I->expectTo('see sidebar menu');
        $I->seeLink('Управление типами');
        $I->seeLink('Добавить тип');
        $I->seeLink('Редактировать тип');
        $I->seeLink('Удалить тип');
        $I->fillField('Type[name]', 'Телефоны');
        $I->click('Сохранить тип и закрыть');
        $I->wait(1);
        $I->seeInCurrentUrl(self::BACKEND_TYPE_PATH);
        $I->see('Тип товара обновлен', '.alert-success');
        $I->seeLink('Телефоны');

        $I->amGoingTo('test deleting type');
        $I->amOnPage(self::BACKEND_TYPE_PATH);
        $I->seeLink('Телефоны');
        $I->amOnPage(self::BACKEND_TYPE_PATH . '/delete/3');
        $I->expectTo('see an error message');
        $I->see('Неверный запрос. Пожалуйста, больше не повторяйте такие запросы', '.alert-danger');
        $I->amOnPage(self::BACKEND_TYPE_PATH);
        $I->expectTo('delete type via ajax request');
        $I->executeJS('
            $.post(
                document.location.href + "/delete/3", 
                {"YUPE_TOKEN":yupeToken}
            );
        ');
        $I->wait(1);
        $I->reloadPage();
        $I->dontSeeLink('Телефоны');
    }
}