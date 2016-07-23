<?php
namespace tests\acceptance\store;

use \WebGuy;
use Facebook\WebDriver\WebDriverKeys;
use tests\acceptance\pages\CommonPage;
use tests\acceptance\user\steps\UserSteps;

class StoreAttributeCest
{
    const BACKEND_ATTR_PATH = '/backend/store/attribute';

    public function tryToTestAttributes(WebGuy $I, $scenario)
    {
        $I = new UserSteps($scenario);
        $I->loginAsAdminAndGoToThePanel(CommonPage::TEST_USER_NAME, CommonPage::TEST_PASSWORD);
        $I->am('administrator');

        $I->amGoingTo('test backend attr list');
        $I->amOnPage(self::BACKEND_ATTR_PATH);
        $I->see('Атрибуты', 'h1');
        $I->expectTo('see sidebar menu');
        $I->seeLink('Атрибуты');
        $I->seeLink('Добавить');
        $I->expectTo('see attr groups');
        $I->see('Группы атрибутов', 'legend');
        $I->seeLink('Группа1');
        $I->seeLink('Группа2');

        $I->expectTo('see attr list');
        $I->see('Название', '.sort-link');
        $I->see('Алиас', '.sort-link');
        $I->see('Группа', '.sort-link');
        $I->see('Тип атрибута', '.sort-link');
        $I->see('Обязательный', '.sort-link');
        $I->see('Фильтр', '.sort-link');
        $I->seeLink('Тип клавиатуры');
        $I->seeLink('Матрица');
        $I->seeLink('Диагональ');
        $I->expectTo('see buttons column');
        $I->seeInPageSource('<a class="update btn btn-sm btn-default" title="" data-toggle="tooltip" href="/index-test.php/backend/store/attribute/update/1"');
        $I->seeInPageSource('<a class="delete btn btn-sm btn-default" title="" data-toggle="tooltip" href="/index-test.php/backend/store/attribute/delete/1"');

        $I->amGoingTo('test attr grid filter');
        $I->fillField('Attribute[title]', 'клав');
        $I->pressKey('#Attribute_title', WebDriverKeys::ENTER);
        $I->wait(1);
        $I->seeLink('Тип клавиатуры');
        $I->dontSeeLink('Матрица');
        $I->dontSeeLink('Диагональ');
        $I->fillField('Attribute[title]', '');
        $I->wait(1);
        $I->fillField('Attribute[name]', 'diag');
        $I->pressKey('#Attribute_name', WebDriverKeys::ENTER);
        $I->wait(1);
        $I->seeLink('Диагональ');
        $I->dontSeeLink('Тип клавиатуры');
        $I->dontSeeLink('Матрица');
        $I->fillField('Attribute[name]', '');
        $I->wait(1);
        $I->selectOption('Attribute[group_id]', 'Группа1');
        $I->wait(1);
        $I->dontSeeLink('Тип клавиатуры');
        $I->seeLink('Матрица');
        $I->seeLink('Диагональ');
        $I->selectOption('Attribute[type]', 'Число');
        $I->wait(1);
        $I->seeLink('Диагональ');
        $I->dontSeeLink('Тип клавиатуры');
        $I->dontSeeLink('Матрица');
        $I->amOnPage(self::BACKEND_ATTR_PATH);
        $I->selectOption('Attribute[required]', 'Да');
        $I->wait(1);
        $I->see('Нет результатов.');
        $I->selectOption('Attribute[required]', 'Нет');
        $I->wait(1);
        $I->seeLink('Матрица');
        $I->seeLink('Диагональ');
        $I->seeLink('Тип клавиатуры');
        $I->amOnPage(self::BACKEND_ATTR_PATH);
        $I->selectOption('Attribute[is_filter]', 'Нет');
        $I->wait(1);
        $I->see('Нет результатов.');
        $I->selectOption('Attribute[is_filter]', 'Да');
        $I->wait(1);
        $I->seeLink('Матрица');
        $I->seeLink('Диагональ');
        $I->seeLink('Тип клавиатуры');

        $I->amGoingTo('add a new attr');
        $I->amOnPage(self::BACKEND_ATTR_PATH . '/create');
        $I->see('Атрибут', 'h1');
        $I->expectTo('see validation errors');
        $I->click('Добавить атрибут и закрыть');
        $I->see('Необходимо заполнить поле «Тип атрибута»', '.error');
        $I->see('Необходимо заполнить поле «Название»', '.error');
        $I->see('Необходимо заполнить поле «Алиас»', '.error');

        $I->selectOption('Attribute[type]', 'Число');
        $I->fillField('Attribute[title]', 'Ширина');
        $I->wait(1);
        $I->seeInField('Attribute[name]', 'shirina');
        $I->fillField('Attribute[unit]', 'м');
        $I->seeCheckboxIsChecked('Attribute[is_filter]');
        $I->click('Добавить атрибут и закрыть');
        $I->wait(1);
        $I->seeInCurrentUrl(self::BACKEND_ATTR_PATH);
        $I->see('Атрибут создан', '.alert-success');
        $I->seeLink('Ширина');

        $I->amGoingTo('test deleting attributes');
        $I->amOnPage(self::BACKEND_ATTR_PATH . '/delete/4');
        $I->expectTo('see an error message');
        $I->see('Неверный запрос. Пожалуйста, больше не повторяйте такие запросы', '.alert-danger');
        $I->amOnPage(self::BACKEND_ATTR_PATH);
        $I->expectTo('delete attr via ajax request');
        $I->executeJS('
            $.post(
                document.location.href + "/delete/4", 
                {"YUPE_TOKEN":yupeToken}
            );
        ');
        $I->wait(1);
        $I->reloadPage();
        $I->seeLink('Диагональ');
        $I->dontSeeLink('Ширина');
    }
}