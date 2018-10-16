<?php
namespace tests\acceptance\store;

use \WebGuy;
use Facebook\WebDriver\WebDriverKeys;
use tests\acceptance\pages\CommonPage;
use tests\acceptance\user\steps\UserSteps;

class StoreBrandCest
{
    const FRONTEND_BRANDS_PATH = '/store/brands';
    const BACKEND_BRANDS_PATH = '/backend/store/producer';

    public function tryToTestBrands(WebGuy $I, $scenario)
    {
        $I->am('normal user');
        $I->amGoingTo('test brands list page');
        $I->amOnPage(self::FRONTEND_BRANDS_PATH);
        $I->expectTo('see brands list with active status');
        $I->see('Все бренды', 'h2');
        $I->seeLink('Intel');
        $I->seeLink('Dell');
        $I->dontSeeLink('A4Tech');
        $I->dontSeeLink('Samsung');

        $I->amGoingTo('visit a brand page');
        $I->click('Intel');
        $I->seeInCurrentUrl('/store/brand/intel');
        $I->seeInTitle('Intel');
        $I->see('Все товары производителя «Intel»', 'h2');
        $I->see('Описание бренда Intel', 'p');
        $I->see('Нет результатов.');
        $I->seeLink('Все бренды');
        $I->click('Все бренды');
        $I->seeInCurrentUrl(self::FRONTEND_BRANDS_PATH);
        $I->click('Dell');
        $I->see('Все товары производителя «Dell»', 'h2');
        $I->dontSee('Нет результатов.');
        $I->see('Сортировка:');
        $I->seeLink('Артикул');
        $I->seeLink('Название');
        $I->seeLink('Цена');
        $I->seeLink('Обновлено');
        $I->seeLink('Dell U2715H');
        $I->seeLink('Dell P2214H');

        $I->amGoingTo('visit inactive brand page');
        $I->expectTo('see 404 error');
        $I->amOnPage('/store/brand/samsung');
        $I->see('Ошибка 404!', 'h2');

        $I = new UserSteps($scenario);
        $I->loginAsAdminAndGoToThePanel(CommonPage::TEST_USER_NAME, CommonPage::TEST_PASSWORD);
        $I->am('administrator');

        $I->amGoingTo('test backend brands list');
        $I->amOnPage(self::BACKEND_BRANDS_PATH);
        $I->see('Бренды', 'h1');
        $I->expectTo('see sidebar menu');
        $I->seeLink('Все бренды');
        $I->seeLink('Добавить');
        $I->expectTo('see brand list');
        $I->seeLink('Intel');
        $I->seeLink('Dell');
        $I->seeLink('A4Tech');
        $I->seeLink('Samsung');
        $I->expectTo('see buttons column');
        $I->seeInPageSource('<a class="front-view btn btn-sm btn-default" target="_blank" title="" data-toggle="tooltip" href="/index-test.php/store/brand/intel"');
        $I->seeInPageSource('<a class="view btn btn-sm btn-default" title="" data-toggle="tooltip" href="/index-test.php/backend/store/producer/view/1"');
        $I->seeInPageSource('<a class="update btn btn-sm btn-default" title="" data-toggle="tooltip" href="/index-test.php/backend/store/producer/update/1"');
        $I->seeInPageSource('<a class="delete btn btn-sm btn-default" title="" data-toggle="tooltip" href="/index-test.php/backend/store/producer/delete/1"');

        $I->amGoingTo('test brand grid filter');
        $I->fillField('Producer[name]', 'Intel');
        $I->pressKey('#Producer_name', WebDriverKeys::ENTER);
        $I->wait(1);
        $I->seeLink('Intel');
        $I->dontSeeLink('Dell');
        $I->dontSeeLink('A4Tech');
        $I->dontSeeLink('Samsung');
        $I->fillField('Producer[name]', '');
        $I->wait(1);
        $I->fillField('Producer[name_short]', 'Dell');
        $I->pressKey('#Producer_name_short', WebDriverKeys::ENTER);
        $I->wait(1);
        $I->seeLink('Dell');
        $I->dontSeeLink('Intel');
        $I->dontSeeLink('A4Tech');
        $I->dontSeeLink('Samsung');
        $I->fillField('Producer[name_short]', '');
        $I->wait(1);
        $I->fillField('Producer[slug]', 'sams');
        $I->pressKey('#Producer_slug', WebDriverKeys::ENTER);
        $I->wait(1);
        $I->seeLink('Samsung');
        $I->dontSeeLink('Intel');
        $I->dontSeeLink('A4Tech');
        $I->dontSeeLink('Dell');
        $I->fillField('Producer[slug]', '');
        $I->wait(1);
        $I->pressKey('#Producer_slug', WebDriverKeys::ENTER);
        $I->wait(1);
        $I->selectOption('Producer[status]', 'Доступен');
        $I->wait(1);
        $I->seeLink('Intel');
        $I->seeLink('Dell');
        $I->dontSeeLink('A4Tech');
        $I->dontSeeLink('Samsung');

        $I->amGoingTo('change brand status');
        $I->amOnPage(self::BACKEND_BRANDS_PATH . '/update/4');
        $I->selectOption('Producer[status]', 'Доступен');
        $I->click('Сохранить производителя и закрыть');
        $I->wait(1);
        $I->seeInCurrentUrl(self::BACKEND_BRANDS_PATH);
        $I->see('Запись изменена!', '.alert-success');
        $I->amOnPage(self::FRONTEND_BRANDS_PATH);
        $I->expectTo('see updated brand');
        $I->see('Все бренды', 'h2');
        $I->seeLink('Intel');
        $I->seeLink('Dell');
        $I->seeLink('Samsung');
        $I->dontSeeLink('A4Tech');

        $I->amGoingTo('add a new brand');
        $I->amOnPage(self::BACKEND_BRANDS_PATH . '/create');
        $I->see('Производитель', 'h1');
        $I->seeOptionIsSelected('Producer[status]', 'Доступен');
        $I->expectTo('see validation errors');
        $I->click('Добавить производителя и закрыть');
        $I->see('Необходимо заполнить поле «Короткое название»', '.error');
        $I->see('Необходимо заполнить поле «Название»', '.error');
        $I->see('Необходимо заполнить поле «URL»', '.error');
        $I->fillField('Producer[name_short]', 'Lenovo');
        $I->wait(1);
        $I->seeInField('Producer[slug]', 'lenovo');
        $I->fillField('Producer[name]', 'Lenovo');
        $I->click('Данные для поисковой оптимизации');
        $I->fillField('Producer[meta_title]', 'Lenovo. Заголовок страницы');
        $I->fillField('Producer[meta_keywords]', 'Lenovo. Ключевые слова');
        $I->fillField('Producer[meta_description]', 'Lenovo. Описание страницы');
        $I->expectTo('see successful addition of data');
        $I->click('Добавить производителя и закрыть');
        $I->wait(1);
        $I->seeInCurrentUrl(self::BACKEND_BRANDS_PATH);
        $I->see('Запись добавлена!', '.alert-success');
        $I->seeLink('Lenovo');

        $I->amGoingTo('see created brand');
        $I->amOnPage(self::BACKEND_BRANDS_PATH . '/view/5');
        $I->see('Просмотр производителя', 'h1');
        $I->expectTo('see brand detail view table');
        $I->see('Lenovo', 'td');
        $I->see('Доступен', 'td');
        $I->see('Lenovo. Заголовок страницы', 'td');
        $I->expectTo('see sidebar menu');
        $I->seeLink('Все бренды');
        $I->seeLink('Добавить');
        $I->seeLink('Редактировать производителя');
        $I->seeLink('Просмотреть производителя');
        $I->seeLink('Удалить производителя');
        $I->amOnPage(self::FRONTEND_BRANDS_PATH);
        $I->seeLink('Lenovo');
        $I->click('Lenovo');
        $I->seeInCurrentUrl('/store/brand/lenovo');
        $I->see('Все товары производителя «Lenovo»', 'h2');
        $I->seeInTitle('Lenovo. Заголовок страницы');
        $I->seeInPageSource('<meta name="description" content="Lenovo. Описание страницы"');
        $I->seeInPageSource('<meta name="keywords" content="Lenovo. Ключевые слова"');

        $I->amGoingTo('test deleting brand');
        $I->amOnPage(self::BACKEND_BRANDS_PATH);
        $I->seeLink('Lenovo');
        $I->amOnPage(self::BACKEND_BRANDS_PATH . '/delete/5');
        $I->expectTo('see an error message');
        $I->see('Неверный запрос. Пожалуйста, больше не повторяйте такие запросы', '.alert-danger');
        $I->amOnPage(self::BACKEND_BRANDS_PATH);
        $I->expectTo('delete brand via ajax request');
        $I->executeJS('
            $.post(
                document.location.href + "/delete/5", 
                {"YUPE_TOKEN":yupeToken}
            );
        ');
        $I->wait(1);
        $I->reloadPage();
        $I->dontSeeLink('Lenovo');
    }
}