<?php
namespace tests\acceptance\store;

use \WebGuy;
use Facebook\WebDriver\WebDriverKeys;
use tests\acceptance\pages\CommonPage;
use tests\acceptance\user\steps\UserSteps;

class StoreCategoryCest
{
    const FRONTEND_CATEGORIES_PATH = '/store/categories';
    const BACKEND_CATEGORIES_PATH = '/backend/store/category';

    public function tryToTestCategories(WebGuy $I, $scenario)
    {
        $I->am('normal user');
        $I->amGoingTo('test store categories list page');
        $I->amOnPage(self::FRONTEND_CATEGORIES_PATH);
        $I->expectTo('see published categories list');
        $I->see('Каталог товаров', 'h2');
        $I->seeLink('Компьютеры');
        $I->seeLink('Мониторы');
        $I->dontSeeLink('Клавиатуры');
        $I->dontSeeLink('Телефоны');

        $I->amGoingTo('visit a category page');
        $I->click('Компьютеры');
        $I->seeInCurrentUrl('/store/computer');
        $I->see('Компьютеры', 'h1');

        $I->amGoingTo('visit a draft category page');
        $I->expectTo('see 404 error');
        $I->amOnPage('/store/computer/keyboard');
        $I->see('Ошибка 404!', 'h2');

        $I = new UserSteps($scenario);
        $I->loginAsAdminAndGoToThePanel(CommonPage::TEST_USER_NAME, CommonPage::TEST_PASSWORD);
        $I->am('administrator');

        $I->amGoingTo('test backend categories list');
        $I->amOnPage(self::BACKEND_CATEGORIES_PATH);
        $I->see('Категории', 'h1');
        $I->seeLink('Все категории');
        $I->seeLink('Новая категория');
        $I->seeLink('Компьютеры');
        $I->seeLink('Мониторы');
        $I->seeLink('Клавиатуры');
        $I->seeLink('a', '/store/computer');
        $I->seeLink('a', self::BACKEND_CATEGORIES_PATH . '/view/1');
        $I->seeLink('a', self::BACKEND_CATEGORIES_PATH . '/delete/1');

        $I->amGoingTo('test category grid filter');
        $I->fillField('StoreCategory[name]', 'Комп');
        $I->pressKey('#StoreCategory_name', WebDriverKeys::ENTER);
        $I->wait(1);
        $I->seeLink('Компьютеры');
        $I->dontSeeLink('Мониторы');
        $I->dontSeeLink('Клавиатуры');
        $I->fillField('StoreCategory[name]', '');
        $I->wait(1);
        $I->fillField('StoreCategory[slug]', 'disp');
        $I->pressKey('#StoreCategory_slug', WebDriverKeys::ENTER);
        $I->wait(1);
        $I->seeLink('Мониторы');
        $I->dontSeeLink('Компьютеры');
        $I->dontSeeLink('Клавиатуры');
        $I->fillField('StoreCategory[slug]', '');
        $I->pressKey('#StoreCategory_slug', WebDriverKeys::ENTER);
        $I->wait(1);
        $I->selectOption('StoreCategory[parent_id]', 'Компьютеры');
        $I->wait(1);
        $I->dontSeeLink('Компьютеры');
        $I->seeLink('Мониторы');
        $I->seeLink('Клавиатуры');
        $I->amOnPage(self::BACKEND_CATEGORIES_PATH);
        $I->selectOption('StoreCategory[status]', 'Черновик');
        $I->wait(1);
        $I->seeLink('Клавиатуры');
        $I->dontSeeLink('Мониторы');
        $I->dontSeeLink('Компьютеры');

        $I->amGoingTo('change category status');
        $I->amOnPage(self::BACKEND_CATEGORIES_PATH . '/update/3');
        $I->selectOption('StoreCategory[status]', 'Опубликовано');
        $I->click('Сохранить категорию и закрыть');
        $I->amOnPage(self::FRONTEND_CATEGORIES_PATH);
        $I->see('Каталог товаров', 'h2');
        $I->seeLink('Компьютеры');
        $I->seeLink('Мониторы');
        $I->seeLink('Клавиатуры');
        $I->dontSeeLink('Телефоны');

        $I->amGoingTo('add a new category');
        $I->amOnPage(self::BACKEND_CATEGORIES_PATH . '/create');
        $I->see('Категория', 'h1');
        $I->seeOptionIsSelected('StoreCategory[status]', 'Опубликовано');
        $I->expectTo('see validation errors');
        $I->click('Добавить категорию и закрыть');
        $I->see('Необходимо заполнить поле «Название»', '.error');
        $I->see('Необходимо заполнить поле «Алиас»', '.error');
        $I->fillField('StoreCategory[name]', 'Телефоны');
        $I->wait(1);
        $I->seeInField('StoreCategory[slug]', 'telefony');
        $I->click('Данные для поисковой оптимизации');
        $I->fillField('StoreCategory[title]', 'Телефоны. Заголовок h1');
        $I->fillField('StoreCategory[meta_title]', 'Телефоны. Заголовок страницы');
        $I->fillField('StoreCategory[meta_keywords]', 'Телефоны. Ключевые слова');
        $I->fillField('StoreCategory[meta_description]', 'Телефоны. Описание страницы');
        $I->expectTo('see successful addition of data');
        $I->click('Добавить категорию и закрыть');
        $I->wait(1);
        $I->seeInCurrentUrl(self::BACKEND_CATEGORIES_PATH);
        $I->see('Запись добавлена!', '.alert-success');
        $I->seeLink('Телефоны');

        $I->amGoingTo('see created category');
        $I->amOnPage(self::BACKEND_CATEGORIES_PATH . '/view/4');
        $I->see('Просмотр категории', 'h1');
        $I->expectTo('see category detail view table');
        $I->see('Телефоны', 'td');
        $I->see('telefony', 'td');
        $I->see('Опубликовано', 'td');
        $I->expectTo('see sidebar menu');
        $I->seeLink('Все категории');
        $I->seeLink('Новая категория');
        $I->seeLink('Редактировать категорию');
        $I->seeLink('Просмотреть категорию');
        $I->seeLink('Удалить категорию');
        $I->amOnPage(self::FRONTEND_CATEGORIES_PATH);
        $I->seeLink('Телефоны', '/store/telefony');
        $I->click('Телефоны');
        $I->seeInCurrentUrl('/store/telefony');
        $I->see('Телефоны. Заголовок h1', 'h1');
        $I->seeInTitle('Телефоны. Заголовок страницы');
        $I->seeInPageSource('<meta name="description" content="Телефоны. Описание страницы"');
        $I->seeInPageSource('<meta name="keywords" content="Телефоны. Ключевые слова"');

        $I->amGoingTo('test deleting categories');
        $I->amOnPage(self::BACKEND_CATEGORIES_PATH);
        $I->seeLink('Компьютеры');
        $I->seeLink('Мониторы');
        $I->seeLink('Клавиатуры');
        $I->seeLink('Телефоны');
        $I->amOnPage(self::BACKEND_CATEGORIES_PATH . '/delete/4');
        $I->expectTo('see an error message');
        $I->see('Неверный запрос. Пожалуйста, больше не повторяйте такие запросы', '.alert-danger');
        $I->amOnPage(self::BACKEND_CATEGORIES_PATH);
        $I->expectTo('delete category via ajax request');
        $I->executeJS('
            $.post(
                document.location.href + "/delete/4", 
                {"YUPE_TOKEN":yupeToken}
            );
        ');
        $I->wait(1);
        $I->reloadPage();
        $I->seeLink('Компьютеры');
        $I->seeLink('Мониторы');
        $I->seeLink('Клавиатуры');
        $I->dontSeeLink('Телефоны');
    }
}