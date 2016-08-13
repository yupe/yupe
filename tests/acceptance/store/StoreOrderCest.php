<?php
namespace tests\acceptance\store;

use \WebGuy;
use Facebook\WebDriver\WebDriverKeys;
use tests\acceptance\pages\CommonPage;
use tests\acceptance\user\steps\UserSteps;

class StoreOrderCest
{
    const BACKEND_ORDER_STATUS_PATH = '/backend/order/status';

    public function tryToTestOrderStatusBackend(WebGuy $I, $scenario)
    {
        $I->wantToTest('order status');

        $I = new UserSteps($scenario);
        $I->loginAsAdminAndGoToThePanel(CommonPage::TEST_USER_NAME, CommonPage::TEST_PASSWORD);
        $I->am('administrator');

        $I->amOnPage(self::BACKEND_ORDER_STATUS_PATH);

        $I->see('Статусы заказа', 'h1');
        $I->see('управление', 'small');

        $I->expectTo('see sidebar menu');
        $I->seeLink('Все заказы');
        $I->seeLink('Добавить заказ');
        $I->seeLink('Статусы заказов');
        $I->seeLink('Добавить статус');

        $I->expectTo('see order status table');
        $I->see('Элементы 1—4 из 4.', '.summary');
        $I->see('Добавить', '.btn-success');
        $I->see('Удалить', '#delete-orderstatus');
        $I->see('№', '.sort-link');
        $I->see('Название', '.sort-link');
        $I->see('Новый', '.label-default');
        $I->see('Принят', '.label-info');
        $I->see('Выполнен', '.label-success');
        $I->see('Удален', '.label-danger');

        $I->amGoingTo('test status filter');
        $I->seeElement('input', ['name' => 'OrderStatus[name]']);
        $I->fillField('OrderStatus[name]', 'Новый');
        $I->pressKey('#OrderStatus_name', WebDriverKeys::ENTER);
        $I->wait(1);
        $I->see('Новый', '.label-default');
        $I->dontSee('Принят', '.label-info');
        $I->dontSee('Выполнен', '.label-success');
        $I->dontSee('Удален', '.label-danger');

        $I->amGoingTo('add a new status');
        $I->amOnPage(self::BACKEND_ORDER_STATUS_PATH . '/create');
        $I->see('Статусы заказа', 'h1');
        $I->see('добавление', 'small');
        $I->seeLink('Все заказы');
        $I->seeLink('Добавить заказ');
        $I->seeLink('Статусы заказов');
        $I->seeLink('Добавить статус');
        $I->seeElement('input', ['name' => 'OrderStatus[name]']);

        $I->amGoingTo('send form without data');
        $I->expectTo('see validation error');
        $I->click('Добавить статус и продолжить');
        $I->see('Необходимо заполнить поле «Название».', '.error');

        $I->fillField('OrderStatus[name]', 'Отменен');
        $I->click('Добавить статус и закрыть');
        $I->wait(1);
        $I->seeInCurrentUrl(self::BACKEND_ORDER_STATUS_PATH);
        $I->see('Запись добавлена!', '.alert-success');
        $I->see('Отменен', 'td');

        $I->amGoingTo('update system status');
        $I->expectTo('see error');
        $I->amOnPage(self::BACKEND_ORDER_STATUS_PATH . '/update/1');
        $I->see('Ошибка 404!', 'h2');

        $I->amGoingTo('update status');
        $I->amOnPage(self::BACKEND_ORDER_STATUS_PATH . '/update/5');
        $I->seeInField('OrderStatus[name]', 'Отменен');
        $I->fillField('OrderStatus[name]', 'Изменен');
        $I->click('Сохранить статус и закрыть');
        $I->wait(1);
        $I->seeInCurrentUrl(self::BACKEND_ORDER_STATUS_PATH);
        $I->see('Запись изменена!', '.alert-success');
        $I->see('Изменен', 'td');

        $I->amGoingTo('delete status');
        $I->amOnPage(self::BACKEND_ORDER_STATUS_PATH . '/delete/5');
        $I->expectTo('see an error message');
        $I->see('Неверный запрос. Пожалуйста, больше не повторяйте такие запросы', '.alert-danger');
        $I->amOnPage(self::BACKEND_ORDER_STATUS_PATH);
        $I->expectTo('delete status via ajax request');
        $I->executeJS('
            $.post(
                document.location.href + "/delete/5", 
                {"YUPE_TOKEN":yupeToken}
            );
        ');
        $I->wait(1);
        $I->reloadPage();
        $I->dontSee('Изменен', 'td');
    }
}