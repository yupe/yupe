<?php
namespace tests\acceptance\store;

use \WebGuy;
use Facebook\WebDriver\WebDriverKeys;
use tests\acceptance\pages\CommonPage;
use tests\acceptance\user\steps\UserSteps;

class StoreOrderCest
{
    const BACKEND_ORDER_STATUS_PATH = '/backend/order/status';
    const BACKEND_ORDER_CLIENT_PATH = '/backend/order/client';

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

    public function tryToTestOrderClientBackend(WebGuy $I, $scenario) {
        $I->wantToTest('order clients');

        $I = new UserSteps($scenario);
        $I->loginAsAdminAndGoToThePanel(CommonPage::TEST_USER_NAME, CommonPage::TEST_PASSWORD);
        $I->am('administrator');

        $I->amOnPage(self::BACKEND_ORDER_CLIENT_PATH);

        $I->see('Клиенты', 'h1');
        $I->see('управление', 'small');

        $I->expectTo('see sidebar menu');
        $I->seeLink('Клиенты');
        $I->seeLink('Добавить клиента');

        $I->expectTo('see client list table');
        $I->see('Элементы 1—2 из 2.', '.summary');
        $I->see('Добавить', '.btn-success');
        $I->see('Удалить', '#delete-client');
        $I->see('Фамилия', '.sort-link');
        $I->see('Имя', '.sort-link');
        $I->see('Отчество', '.sort-link');
        $I->see('Email', '.sort-link');
        $I->see('Телефон', '.sort-link');
        $I->see('Заказы', '.sort-link');
        $I->see('Оборот', '.sort-link');
        $I->see('Регистрация', '.sort-link');
        $I->see('Визит', '.sort-link');
        $I->see('Статус', '.sort-link');
        $I->seeLink('Платежеспособный');
        $I->seeLink('Клиент');
        $I->seeLink('Бабосович');
        $I->seeLink('test@my.app');
        $I->see('13 320,00 руб.', '.label-default');
        $I->seeLink('+7(123)345-56-67');
        $I->seeLink('Багин');
        $I->seeLink('Тестер');
        $I->seeLink('Петрович');
        $I->seeLink('yupe@yupe.local');
        $I->see('38 600,00 руб.', '.label-default');

        $I->amGoingTo('test client filter');
        $I->seeElement('input', ['name' => 'Client[last_name]']);
        $I->seeElement('input', ['name' => 'Client[first_name]']);
        $I->seeElement('input', ['name' => 'Client[middle_name]']);
        $I->seeElement('input', ['name' => 'Client[email]']);
        $I->seeElement('input', ['name' => 'Client[phone]']);
        $I->seeElement('input', ['name' => 'Client[ordersTotalNumber]']);
        $I->seeElement('input', ['name' => 'Client[ordersTotalSum]']);
        $I->seeElement('select', ['name' => 'Client[status]']);
        $I->fillField('Client[last_name]', 'баг');
        $I->pressKey('#Client_last_name', WebDriverKeys::ENTER);
        $I->wait(1);
        $I->seeLink('Багин');
        $I->dontSeeLink('Платежеспособный');
        $I->amOnPage(self::BACKEND_ORDER_CLIENT_PATH);
        $I->fillField('Client[first_name]', 'Клиент');
        $I->pressKey('#Client_first_name', WebDriverKeys::ENTER);
        $I->wait(1);
        $I->seeLink('Платежеспособный');
        $I->dontSeeLink('Багин');
        $I->amOnPage(self::BACKEND_ORDER_CLIENT_PATH);
        $I->fillField('Client[middle_name]', 'Петр');
        $I->pressKey('#Client_middle_name', WebDriverKeys::ENTER);
        $I->wait(1);
        $I->seeLink('Багин');
        $I->dontSeeLink('Платежеспособный');
        $I->amOnPage(self::BACKEND_ORDER_CLIENT_PATH);
        $I->fillField('Client[email]', 'yupe');
        $I->pressKey('#Client_email', WebDriverKeys::ENTER);
        $I->wait(1);
        $I->seeLink('Багин');
        $I->dontSeeLink('Платежеспособный');
        $I->amOnPage(self::BACKEND_ORDER_CLIENT_PATH);
        $I->fillField('Client[phone]', '345-56');
        $I->pressKey('#Client_phone', WebDriverKeys::ENTER);
        $I->wait(1);
        $I->seeLink('Платежеспособный');
        $I->dontSeeLink('Багин');
        $I->amOnPage(self::BACKEND_ORDER_CLIENT_PATH);
        $I->selectOption('Client[status]', 'Заблокирован');
        $I->wait(1);
        $I->see('Нет результатов.');
        $I->selectOption('Client[status]', 'Активен');
        $I->wait(1);
        $I->seeLink('Багин');
        $I->seeLink('Платежеспособный');

        $I->amGoingTo('view client page');
        $I->click('Багин');
        $I->wait(1);
        $I->seeInCurrentUrl(self::BACKEND_ORDER_CLIENT_PATH . '/view/1');
        $I->see('Клиент', 'h1');
        $I->see('«yupe»', 'small');

        $I->expectTo('see sidebar menu');
        $I->seeLink('Клиенты');
        $I->seeLink('Добавить клиента');

        $I->expectTo('see client detail information table');
        $I->seeElement('table', ['class' => 'detail-view table table-striped table-condensed']);
        $I->see('ФИО', 'th');
        $I->see('Багин Тестер Петрович', 'td');
        $I->see('Ник', 'th');
        $I->see('yupe', 'td');
        $I->see('Email', 'th');
        $I->see('yupe@yupe.local', 'td');
        $I->see('Оборот', 'th');
        $I->see('38 600,00 руб.', '.label-success');

        $I->expectTo('table with orders detail info');
        $I->seeElement('table', ['class' => 'items table table-condensed']);
        $I->seeLink('14.08.16');
        $I->see('2 500,00 руб.', 'td');
        $I->see('Самовывоз', 'td');

        $I->expectTo('see comment form');
        $I->see('Комментарии 0');
        $I->seeElement('textarea', ['name' => 'Comment[text]']);
        $I->see('Добавить комментарий');
    }
}
