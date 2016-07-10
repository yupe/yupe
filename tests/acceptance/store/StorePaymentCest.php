<?php
namespace tests\acceptance\store;

use \WebGuy;
use Facebook\WebDriver\WebDriverKeys;
use tests\acceptance\pages\CommonPage;
use tests\acceptance\user\steps\UserSteps;

class StorePaymentCest
{
    const BACKEND_PAYMENT_PATH = '/backend/payment/payment';

    public function tryToTestPaymentBackend(WebGuy $I, $scenario)
    {
        $I = new UserSteps($scenario);
        $I->loginAsAdminAndGoToThePanel(CommonPage::TEST_USER_NAME, CommonPage::TEST_PASSWORD);
        $I->am('administrator');

        $I->wantToTest('store payment backend');
        $I->amOnPage(self::BACKEND_PAYMENT_PATH);

        $I->expectTo('see sidebar menu');
        $I->seeLink('Управление способами оплаты');
        $I->seeLink('Добавить способ оплаты');

        $I->see('Способы оплаты', 'h1');
        $I->see('управление', 'small');

        $I->expectTo('see payment table');
        $I->see('Элементы 1—2 из 2.', '.summary');
        $I->seeElement('table', ['class' => 'items table table-condensed']);
        $I->see('Название', '.sort-link');
        $I->see('Платежная система', '.sort-link');
        $I->see('Статус', '.sort-link');
        $I->seeLink('Наличными');
        $I->seeLink('Робокасса');
        $I->seeInPageSource('<a class="update btn btn-sm btn-default" title="" data-toggle="tooltip" href="/index-test.php/backend/payment/payment/update/1" data-original-title="Редактировать"');
        $I->seeInPageSource('<a class="delete btn btn-sm btn-default" title="" data-toggle="tooltip" href="/index-test.php/backend/payment/payment/delete/1" data-original-title="Удалить"');

        $I->amGoingTo('test payment filter');
        $I->seeElement('input', ['name' => 'Payment[name]']);
        $I->seeElement('input', ['name' => 'Payment[module]']);
        $I->seeElement('select', ['name' => 'Payment[status]']);

        $I->fillField('Payment[name]', 'Наличными');
        $I->pressKey('#Payment_name', WebDriverKeys::ENTER);
        $I->wait(1);
        $I->seeLink('Наличными');
        $I->dontSeeLink('Робокасса');

        $I->amOnPage(self::BACKEND_PAYMENT_PATH);
        $I->fillField('Payment[module]', 'robokassa');
        $I->pressKey('#Payment_module', WebDriverKeys::ENTER);
        $I->wait(1);
        $I->seeLink('Робокасса');
        $I->dontSeeLink('Наличными');

        $I->amOnPage(self::BACKEND_PAYMENT_PATH);
        $I->selectOption('Payment[status]', 'Активен');
        $I->wait(1);
        $I->seeLink('Наличными');
        $I->dontSeeLink('Робокасса');

        $I->amGoingTo('add a new payment');
        $I->amOnPage(self::BACKEND_PAYMENT_PATH . '/create');
        $I->see('Способ оплаты', 'h1');
        $I->see('добавление', 'small');
        $I->seeLink('Управление способами оплаты');
        $I->seeLink('Добавить способ оплаты');
        $I->seeOptionIsSelected('Payment[status]', 'Активен');
        $I->fillField('Payment[name]', 'Тестовый');
        $I->selectOption('Payment[module]', 'Обработка вручную');
        $I->click('Добавить способ оплаты и закрыть');
        $I->wait(1);
        $I->seeInCurrentUrl(self::BACKEND_PAYMENT_PATH);
        $I->see('Запись добавлена!', '.alert-success');
        $I->seeLink('Тестовый');

        $I->amGoingTo('delete payment');
        $I->amOnPage(self::BACKEND_PAYMENT_PATH. '/delete/3');
        $I->expectTo('see an error message');
        $I->see('Неверный запрос. Пожалуйста, больше не повторяйте такие запросы', '.alert-danger');
        $I->amOnPage(self::BACKEND_PAYMENT_PATH);
        $I->expectTo('delete attr via ajax request');
        $I->executeJS('
            $.post(
                document.location.href + "/delete/3", 
                {"YUPE_TOKEN":yupeToken}
            );
        ');
        $I->wait(1);
        $I->reloadPage();
        $I->dontSeeLink('Тестовый');
    }
}