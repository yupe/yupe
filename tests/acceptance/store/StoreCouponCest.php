<?php
namespace tests\acceptance\store;

use \WebGuy;
use Facebook\WebDriver\WebDriverKeys;
use tests\acceptance\pages\CommonPage;
use tests\acceptance\user\steps\UserSteps;

class StoreCouponCest
{
    const BACKEND_COUPON_PATH = '/backend/coupon/coupon';

    public function tryToTestCouponBackend(WebGuy $I, $scenario)
    {
        $I = new UserSteps($scenario);
        $I->loginAsAdminAndGoToThePanel(CommonPage::TEST_USER_NAME, CommonPage::TEST_PASSWORD);
        $I->am('administrator');

        $I->amOnPage(self::BACKEND_COUPON_PATH);
        
        $I->expectTo('see sidebar menu');
        $I->seeLink('Управление купонами');
        $I->seeLink('Добавить купон');

        $I->see('Купоны', 'h1');

        $I->expectTo('see coupon table');
        $I->see('Название', '.sort-link');
        $I->see('Код', '.sort-link');
        $I->see('Дата начала', '.sort-link');
        $I->see('Дата конца', '.sort-link');
        $I->see('Статус', '.sort-link');
        $I->see('Заказы', 'th');

        $I->expectTo('see buttons column');
        $I->seeInPageSource('<a class="view btn btn-sm btn-default" title="" data-toggle="tooltip" href="/index-test.php/backend/coupon/coupon/view/1" data-original-title="Просмотреть"');
        $I->seeInPageSource('<a class="update btn btn-sm btn-default" title="" data-toggle="tooltip" href="/index-test.php/backend/coupon/coupon/update/1" data-original-title="Редактировать"');
        $I->seeInPageSource('<a class="delete btn btn-sm btn-default" title="" data-toggle="tooltip" href="/index-test.php/backend/coupon/coupon/delete/1" data-original-title="Удалить"');

        $I->expectTo('see coupon list');
        $I->seeLink('Купон1');
        $I->seeLink('Купон2');
        $I->seeLink('Купон3');
        $I->seeLink('Купон4');
        $I->see('CPN1');
        $I->see('CPN2');
        $I->see('CPN3');
        $I->see('CPN4');

        $I->amGoingTo('test coupon filter');
        $I->seeElement('input', ['name' => 'Coupon[name]']);
        $I->seeElement('input', ['name' => 'Coupon[code]']);
        $I->seeElement('input', ['name' => 'Coupon[start_time]']);
        $I->seeElement('input', ['name' => 'Coupon[end_time]']);
        $I->seeElement('select', ['name' => 'Coupon[status]']);

        $I->fillField('Coupon[name]', 'Купон1');
        $I->pressKey('#Coupon_name', WebDriverKeys::ENTER);
        $I->wait(1);
        $I->seeLink('Купон1');
        $I->dontSeeLink('Купон2');
        $I->dontSeeLink('Купон3');
        $I->dontSeeLink('Купон4');

        $I->amOnPage(self::BACKEND_COUPON_PATH);
        $I->fillField('Coupon[code]', 'CPN2');
        $I->pressKey('#Coupon_code', WebDriverKeys::ENTER);
        $I->wait(1);
        $I->seeLink('Купон2');
        $I->dontSeeLink('Купон1');
        $I->dontSeeLink('Купон3');
        $I->dontSeeLink('Купон4');

        $I->amOnPage(self::BACKEND_COUPON_PATH);
        $I->fillField('Coupon[end_time]', '2016-07-01');
        $I->pressKey('#Coupon_end_time', WebDriverKeys::ENTER);
        $I->wait(1);
        $I->seeLink('Купон3');
        $I->dontSeeLink('Купон2');
        $I->dontSeeLink('Купон1');
        $I->dontSeeLink('Купон4');

        $I->amOnPage(self::BACKEND_COUPON_PATH);
        $I->selectOption('Coupon[status]', 'Неактивен');
        $I->wait(1);
        $I->seeLink('Купон4');
        $I->dontSeeLink('Купон3');
        $I->dontSeeLink('Купон2');
        $I->dontSeeLink('Купон1');

        $I->amGoingTo('add a new coupon');
        $I->amOnPage(self::BACKEND_COUPON_PATH . '/create');
        $I->see('Купоны', 'h1');
        $I->see('добавление', 'small');
        $I->seeLink('Управление купонами');
        $I->seeLink('Добавить купон');

        $I->seeOptionIsSelected('Coupon[type]', 'Сумма');
        $I->seeOptionIsSelected('Coupon[status]', 'Неактивен');
        $I->seeOptionIsSelected('Coupon[free_shipping]', 'нет');
        $I->seeOptionIsSelected('Coupon[registered_user]', 'нет');

        $I->expectTo('see validation errors');
        $I->click('Добавить купон и закрыть');
        $I->see('Необходимо заполнить поле «Название»', '.error');
        $I->see('Необходимо заполнить поле «Код»', '.error');

        $I->fillField('Coupon[name]', 'Тестовый купон');
        $I->amGoingTo('add coupon with existing code');
        $I->expectTo('see error');
        $I->fillField('Coupon[code]', 'CPN1');
        $I->click('Добавить купон и закрыть');
        $I->see('Код "CPN1" уже занят.', '.error');
        $I->fillField('Coupon[code]', 'test');
        $I->click('Добавить купон и закрыть');
        $I->wait(1);
        $I->seeInCurrentUrl(self::BACKEND_COUPON_PATH);
        $I->see('Запись добавлена!', '.alert-success');
        $I->seeLink('Тестовый купон');

        $I->amGoingTo('view coupon data');
        $I->amOnPage(self::BACKEND_COUPON_PATH . '/view/5');
        $I->see('Просмотр купона', 'h1');
        $I->see('«test»', 'small');
        $I->expectTo('see sidebar menu');
        $I->seeLink('Управление купонами');
        $I->seeLink('Добавить купон');
        $I->seeLink('Редактировать купон');
        $I->seeLink('Просмотреть купон');
        $I->seeLink('Удалить купон');

        $I->seeElement('table', ['class' => 'detail-view table table-striped table-condensed']);
        $I->see('ID', 'th');
        $I->see('5', 'td');
        $I->see('Название', 'th');
        $I->see('Тестовый купон', 'td');
        $I->see('Код', 'th');
        $I->see('test', 'td');
        $I->see('Тип', 'th');
        $I->see('Сумма', 'td');

        $I->amGoingTo('delete coupon');
        $I->amOnPage(self::BACKEND_COUPON_PATH . '/delete/5');
        $I->expectTo('see an error message');
        $I->see('Неверный запрос. Пожалуйста, больше не повторяйте такие запросы', '.alert-danger');
        $I->amOnPage(self::BACKEND_COUPON_PATH);
        $I->expectTo('delete attr via ajax request');
        $I->executeJS('
            $.post(
                document.location.href + "/delete/5", 
                {"YUPE_TOKEN":yupeToken}
            );
        ');
        $I->wait(1);
        $I->reloadPage();
        $I->seeLink('Купон1');
        $I->seeLink('Купон2');
        $I->seeLink('Купон3');
        $I->seeLink('Купон4');
        $I->dontSeeLink('Тестовый купон');
    }
}