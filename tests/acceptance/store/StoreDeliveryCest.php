<?php
namespace tests\acceptance\store;

use \WebGuy;
use Facebook\WebDriver\WebDriverKeys;
use tests\acceptance\pages\CommonPage;
use tests\acceptance\user\steps\UserSteps;

class StoreDeliveryCest
{
    const BACKEND_DELIVERY_PATH = '/backend/delivery/delivery';

    public function tryToTestDeliveryBackend(WebGuy $I, $scenario)
    {
        $I = new UserSteps($scenario);
        $I->loginAsAdminAndGoToThePanel(CommonPage::TEST_USER_NAME, CommonPage::TEST_PASSWORD);
        $I->am('administrator');

        $I->wantToTest('store delivery backend');
        $I->amOnPage(self::BACKEND_DELIVERY_PATH);

        $I->expectTo('see sidebar menu');
        $I->seeLink('Управление способами доставки');
        $I->seeLink('Добавить способ доставки');

        $I->see('Способы доставки', 'h1');
        $I->see('управление', 'small');

        $I->expectTo('see delivery table');
        $I->see('Элементы 1—4 из 4.', '.summary');
        $I->seeElement('table', ['class' => 'items table table-condensed']);
        $I->see('Название', '.sort-link');
        $I->see('Стоимость', '.sort-link');
        $I->see('Бесплатна от', '.sort-link');
        $I->see('Доступна от', '.sort-link');
        $I->see('Статус', '.sort-link');
        $I->seeLink('Самовывоз');
        $I->seeLink('Курьером');
        $I->seeLink('Транспортная компания');
        $I->seeLink('Пункт выдачи');
        $I->seeInPageSource('<a class="update btn btn-sm btn-default" title="" data-toggle="tooltip" href="/index-test.php/backend/delivery/delivery/update/1" data-original-title="Редактировать"');
        $I->seeInPageSource('<a class="delete btn btn-sm btn-default" title="" data-toggle="tooltip" href="/index-test.php/backend/delivery/delivery/delete/1" data-original-title="Удалить"');

        $I->amGoingTo('test delivery filter');
        $I->seeElement('input', ['name' => 'Delivery[name]']);
        $I->seeElement('input', ['name' => 'Delivery[price]']);
        $I->seeElement('input', ['name' => 'Delivery[free_from]']);
        $I->seeElement('input', ['name' => 'Delivery[available_from]']);
        $I->seeElement('select', ['name' => 'Delivery[status]']);

        $I->fillField('Delivery[name]', 'Самовывоз');
        $I->pressKey('#Delivery_name', WebDriverKeys::ENTER);
        $I->wait(1);
        $I->seeLink('Самовывоз');
        $I->dontSeeLink('Курьером');
        $I->dontSeeLink('Транспортная компания');
        $I->dontSeeLink('Пункт выдачи');

        $I->amOnPage(self::BACKEND_DELIVERY_PATH);
        $I->fillField('Delivery[price]', 700);
        $I->pressKey('#Delivery_price', WebDriverKeys::ENTER);
        $I->wait(1);
        $I->seeLink('Транспортная компания');
        $I->dontSeeLink('Курьером');
        $I->dontSeeLink('Самовывоз');
        $I->dontSeeLink('Пункт выдачи');

        $I->amOnPage(self::BACKEND_DELIVERY_PATH);
        $I->fillField('Delivery[free_from]', 30000);
        $I->pressKey('#Delivery_free_from', WebDriverKeys::ENTER);
        $I->wait(1);
        $I->seeLink('Курьером');
        $I->dontSeeLink('Самовывоз');
        $I->dontSeeLink('Транспортная компания');
        $I->dontSeeLink('Пункт выдачи');

        $I->amOnPage(self::BACKEND_DELIVERY_PATH);
        $I->fillField('Delivery[available_from]', 10000);
        $I->pressKey('#Delivery_available_from', WebDriverKeys::ENTER);
        $I->wait(1);
        $I->seeLink('Транспортная компания');
        $I->dontSeeLink('Курьером');
        $I->dontSeeLink('Самовывоз');
        $I->dontSeeLink('Пункт выдачи');

        $I->amOnPage(self::BACKEND_DELIVERY_PATH);
        $I->selectOption('Delivery[status]', 'Неактивен');
        $I->wait(1);
        $I->seeLink('Пункт выдачи');
        $I->dontSeeLink('Транспортная компания');
        $I->dontSeeLink('Курьером');
        $I->dontSeeLink('Самовывоз');

        $I->amGoingTo('add a new delivery');
        $I->amOnPage(self::BACKEND_DELIVERY_PATH . '/create');
        $I->see('Способы доставки', 'h1');
        $I->see('добавление', 'small');
        $I->seeLink('Управление способами доставки');
        $I->seeLink('Добавить способ доставки');
        $I->seeOptionIsSelected('Delivery[status]', 'Активен');
        $I->seeInField('Delivery[price]', '0.00');
        $I->dontSeeCheckboxIsChecked('Delivery[separate_payment]');
        $I->fillField('Delivery[name]', 'Почта России');
        $I->fillField('Delivery[price]', 250);
        $I->click('Добавить доставку и закрыть');
        $I->wait(1);
        $I->seeInCurrentUrl(self::BACKEND_DELIVERY_PATH);
        $I->see('Запись добавлена!', '.alert-success');
        $I->seeLink('Почта России');

        $I->amGoingTo('update delivery');
        $I->amOnPage(self::BACKEND_DELIVERY_PATH . '/update/5');
        $I->see('Редактирование способа доставки', 'h1');
        $I->see('«Почта России»', 'small');

        $I->expectTo('see sidebar menu');
        $I->seeLink('Управление способами доставки');
        $I->seeLink('Добавить способ доставки');
        $I->seeLink('Редактировать способ доставки');
        $I->seeLink('Удалить способ доставки');
        $I->fillField('Delivery[price]', 123);
        $I->click('Сохранить доставку и закрыть');
        $I->wait(1);
        $I->seeInCurrentUrl(self::BACKEND_DELIVERY_PATH);
        $I->see('Запись изменена!', '.alert-success');
        $I->see('123.00', 'td');

        $I->amGoingTo('test delete delivery');
        $I->amOnPage(self::BACKEND_DELIVERY_PATH . '/delete/5');
        $I->expectTo('see an error message');
        $I->see('Неверный запрос. Пожалуйста, больше не повторяйте такие запросы', '.alert-danger');
        $I->amOnPage(self::BACKEND_DELIVERY_PATH);
        $I->expectTo('delete attr via ajax request');
        $I->executeJS('
            $.post(
                document.location.href + "/delete/5", 
                {"YUPE_TOKEN":yupeToken}
            );
        ');
        $I->wait(1);
        $I->reloadPage();
        $I->dontSeeLink('Почта России');

    }
}