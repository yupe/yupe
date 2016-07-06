<?php
namespace tests\acceptance\store;

use \WebGuy;
use Facebook\WebDriver\WebDriverKeys;
use tests\acceptance\pages\CommonPage;
use tests\acceptance\user\steps\UserSteps;

class StoreProductCest
{
    const FRONTEND_PRODUCT_PATH = '/store';
    const BACKEND_PRODUCT_PATH = '/backend/store/product';

    public function tryToTestProductList(WebGuy $I, $scenario)
    {
        $I->wantToTest('product list page');

        $I->am('normal user');
        $I->amOnPage(self::FRONTEND_PRODUCT_PATH);

        $I->see('Каталог товаров', 'h2');

        $I->expectTo('see product sorter');
        $I->see('Сортировка:');
        $I->seeLink('Артикул');
        $I->seeLink('Название');
        $I->seeLink('Цена');
        $I->seeLink('Обновлено');

        $I->expectTo('see product item');
        $I->seeElement('img', [
            'alt' => 'Монитор Dell U2715H',
            'title' => 'Монитор Dell U2715H',
        ]);
        $I->seeLink('Dell U2715H');
        $I->see('36100 руб.', '.price-text-color');

        $I->expectTo('see other products');
        $I->seeLink('Samsung U28E590D');
        $I->seeLink('A4Tech B314 Black USB');
    }

    public function tryToTestProductPage(WebGuy $I, $scenario)
    {
        $I->wantToTest('single product page');

        $I->click('Dell U2715H');
        $I->seeInCurrentUrl('/store/computer/display/dell-u2715h.html');
        $I->seeInTitle('Монитор Dell. Заголовок страницы');
        $I->see('Монитор Dell. Заголовок h1', 'h1');
        $I->seeElement('img', [
            'id' => 'main-image',
            'alt' => 'Монитор Dell U2715H',
            'title' => 'Монитор Dell U2715H',
        ]);
        $I->seeElement('img', [
            'alt' => 'Дополнительное изображение',
            'title' => 'Дополнительное изображение',
        ]);
        $I->see('В наличии', '.label-success');
        $I->see('10 в наличии', 'span');
        $I->see('Матрица');
        $I->see('TFT AH-IPS');
        $I->see('Короткое описание монитора Dell U2715H');
        $I->see('Варианты', 'h4');
        $I->seeElement('#ProductVariant');
        $I->see('Цена: 38000 руб.');
        $I->see('Фиксированная цена со скидкой: 0 руб.');
        $I->see('Скидка: 5%');
        $I->see('Итоговая цена: 36100 руб.');
        $I->seeElement('#product-quantity');
        $I->seeInField('Product[quantity]', '1');
        $I->seeElement('button', ['class' => 'btn btn-default product-quantity-decrease']);
        $I->seeElement('button', ['class' => 'btn btn-default product-quantity-increase']);
        $I->seeElement('button', ['id' => 'add-product-to-cart']);

        $I->amGoingTo('test product info tabs');
        $I->seeLink('Описание');
        $I->seeLink('Данные');
        $I->seeLink('Характеристики');
        $I->seeLink('Комментарии');
        $I->see('Описание монитора Dell U2715H');
        $I->dontSee('Данные монитора Dell U2715H');
        $I->click('Данные');
        $I->see('Данные монитора Dell U2715H');
        $I->click('Характеристики');
        $I->dontSee('Данные монитора Dell U2715H');
        $I->see('Dell', 'td');
        $I->see('TST1', 'td');
        $I->see('613 м', 'td');
        $I->see('410 м', 'td');
        $I->see('205 м', 'td');
        $I->see('7.38 кг', 'td');
        $I->click('Комментарии');
        $I->dontSee('Данные монитора Dell U2715H');
        $I->dontSee('Dell', 'td');
        $I->see('Станьте первым!');
        $I->seeLink('авторизуйтесь');
        $I->seeLink('зарегистрируйтесь');

        $I->amGoingTo('test related products widget');
        $I->see('Связанные товары', 'h3');
        $I->seeLink('Dell P2214H');
        $I->seeLink('Dell U2415');
        $I->see('13320 руб.', '.price-text-color');
        $I->see('21500 руб.', '.price-text-color');
    }

    public function tryToTestProductSearch(WebGuy $I, $scenario)
    {
        $I->wantToTest('product search');

        $I->amOnPage(self::FRONTEND_PRODUCT_PATH);

        $I->seeElement('#q');
        $I->seeLink('Dell U2715H');
        $I->seeLink('Dell P2214H');
        $I->seeLink('Samsung U28E590D');
        $I->seeLink('A4Tech B314 Black USB');

        $I->fillField('#q', 'Sams');
        $I->pressKey('#q', WebDriverKeys::ENTER);
        $I->seeLink('Samsung U28E590D');
        $I->dontSeeLink('Dell U2715H');
        $I->dontSeeLink('Dell P2214H');
        $I->dontSeeLink('A4Tech B314 Black USB');

        $I->fillField('#q', 'Intel');
        $I->pressKey('#q', WebDriverKeys::ENTER);
        $I->see('Нет результатов.', 'span');
    }

    public function tryToTestProductFilter(WebGuy $I, $scenario)
    {
        $I->wantToTest('product filter');

        $I->amOnPage(self::FRONTEND_PRODUCT_PATH);
        $I->see('По цене', 'strong');
        $I->see('По размерам', 'strong');
        $I->see('Категории', 'strong');
        $I->see('Бренды', 'strong');
        $I->see('Тип клавиатуры', 'strong');
        $I->see('Матрица', 'strong');
        $I->see('Диагональ', 'strong');

        $I->seeLink('Dell U2715H');
        $I->seeLink('Dell P2214H');
        $I->seeLink('Samsung U28E590D');
        $I->seeLink('A4Tech B314 Black USB');

        $I->fillField('price[from]', 30000);
        $I->click('Подобрать');
        $I->seeLink('Dell U2715H');
        $I->dontSeeLink('Dell P2214H');
        $I->dontSeeLink('Samsung U28E590D');
        $I->dontSeeLink('A4Tech B314 Black USB');

        $I->amOnPage(self::FRONTEND_PRODUCT_PATH);
        $I->checkOption('#brand_2');
        $I->click('Подобрать');
        $I->seeLink('Dell U2715H');
        $I->seeLink('Dell P2214H');
        $I->dontSeeLink('Samsung U28E590D');
        $I->dontSeeLink('A4Tech B314 Black USB');
        $I->fillField('price[to]', 15000);
        $I->click('Подобрать');
        $I->seeLink('Dell P2214H');
        $I->dontSeeLink('Dell U2715H');

        $I->amOnPage(self::FRONTEND_PRODUCT_PATH);
        $I->fillField('#matrica', 'TFT IPS');
        $I->click('Подобрать');
        $I->seeLink('Dell P2214H');
        $I->dontSeeLink('Dell U2715H');
        $I->dontSeeLink('Samsung U28E590D');
        $I->dontSeeLink('A4Tech B314 Black USB');
    }

    public function tryToTestBackendProductList(WebGuy $I, $scenario)
    {
        $I->wantToTest('backend product list');

        $I = new UserSteps($scenario);
        $I->loginAsAdminAndGoToThePanel(CommonPage::TEST_USER_NAME, CommonPage::TEST_PASSWORD);
        $I->am('administrator');

        $I->amOnPage(self::BACKEND_PRODUCT_PATH);

        $I->see('Товары', 'h1');

        $I->expectTo('see sidebar menu');
        $I->seeLink('Все товары');
        $I->seeLink('Добавить товар');

        $I->see('Элементы 1—5 из 5.', '.summary');
        $I->see('Копировать', '#copy-products');
        $I->see('Добавить', '.btn-success');
        $I->see('Удалить', '#delete-product');

        $I->expectTo('see sort by column links');
        $I->see('Название', '.sort-link');
        $I->see('Артикул', '.sort-link');
        $I->see('Производитель', '.sort-link');
        $I->see('Категория', '.sort-link');
        $I->see('Цена', '.sort-link');
        $I->see('Новая', '.sort-link');
        $I->see('Наличие', '.sort-link');
        $I->see('Остаток', '.sort-link');
        $I->see('Статус', '.sort-link');

        $I->expectTo('see products');
        $I->seeLink('Dell U2715H');
        $I->seeLink('A4Tech B314 Black USB');
        $I->seeLink('Samsung U28E590D');

        $I->expectTo('see product per page selector');
        $I->see('Выводить по');
        $I->see('5', 'button');
        $I->see('20', 'button');
        $I->see('100', 'button');
    }

    public function tryToTestBackendProductListFilter(WebGuy $I, $scenario)
    {
        $I->wantToTest('backend product filter');

        $I = new UserSteps($scenario);
        $I->loginAsAdminAndGoToThePanel(CommonPage::TEST_USER_NAME, CommonPage::TEST_PASSWORD);
        $I->am('administrator');

        $I->amOnPage(self::BACKEND_PRODUCT_PATH);

        $I->expectTo('see grid filter fields');
        $I->seeElement('input', ['name' => 'Product[name]']);
        $I->seeElement('input', ['name' => 'Product[sku]']);
        $I->seeElement('select', ['name' => 'Product[producer_id]']);
        $I->seeElement('select', ['name' => 'Product[category_id]']);
        $I->seeElement('input', ['name' => 'Product[price]']);
        $I->seeElement('input', ['name' => 'Product[discount_price]']);
        $I->seeElement('select', ['name' => 'Product[in_stock]']);
        $I->seeElement('input', ['name' => 'Product[quantity]']);
        $I->seeElement('select', ['name' => 'Product[status]']);

        $I->fillField('Product[name]', 'Dell');
        $I->pressKey('#Product_name', WebDriverKeys::ENTER);
        $I->wait(1);
        $I->seeLink('Dell U2715H');
        $I->seeLink('Dell P2214H');
        $I->seeLink('Dell U2415');
        $I->dontSeeLink('A4Tech B314 Black USB');
        $I->dontSeeLink('Samsung U28E590D');

        $I->amOnPage(self::BACKEND_PRODUCT_PATH);
        $I->fillField('Product[sku]', 'TST5');
        $I->pressKey('#Product_sku', WebDriverKeys::ENTER);
        $I->wait(1);
        $I->seeLink('A4Tech B314 Black USB');
        $I->dontSeeLink('Dell U2715H');
        $I->dontSeeLink('Samsung U28E590D');

        $I->amOnPage(self::BACKEND_PRODUCT_PATH);
        $I->selectOption('Product[producer_id]', 'Samsung');
        $I->wait(1);
        $I->seeLink('Samsung U28E590D');
        $I->dontSeeLink('A4Tech B314 Black USB');
        $I->dontSeeLink('Dell U2715H');

        $I->amOnPage(self::BACKEND_PRODUCT_PATH);
        $I->selectOption('Product[category_id]', 'Клавиатуры');
        $I->wait(1);
        $I->seeLink('A4Tech B314 Black USB');
        $I->dontSeeLink('Samsung U28E590D');
        $I->dontSeeLink('Dell U2715H');

        $I->amOnPage(self::BACKEND_PRODUCT_PATH);
        $I->fillField('Product[price]', '3000');
        $I->pressKey('#Product_price', WebDriverKeys::ENTER);
        $I->wait(1);
        $I->seeLink('A4Tech B314 Black USB');
        $I->dontSeeLink('Dell U2715H');
        $I->dontSeeLink('Samsung U28E590D');

        $I->amOnPage(self::BACKEND_PRODUCT_PATH);
        $I->fillField('Product[discount_price]', '21500');
        $I->pressKey('#Product_discount_price', WebDriverKeys::ENTER);
        $I->wait(1);
        $I->seeLink('Dell U2415');
        $I->dontSeeLink('A4Tech B314 Black USB');
        $I->dontSeeLink('Samsung U28E590D');

        $I->amOnPage(self::BACKEND_PRODUCT_PATH);
        $I->selectOption('Product[in_stock]', 'Нет в наличии');
        $I->wait(1);
        $I->seeLink('Dell P2214H');
        $I->dontSeeLink('A4Tech B314 Black USB');
        $I->dontSeeLink('Samsung U28E590D');
        $I->dontSeeLink('Dell U2715H');

        $I->amOnPage(self::BACKEND_PRODUCT_PATH);
        $I->fillField('Product[quantity]', '10');
        $I->pressKey('#Product_quantity', WebDriverKeys::ENTER);
        $I->wait(1);
        $I->seeLink('Dell U2715H');
        $I->dontSeeLink('A4Tech B314 Black USB');
        $I->dontSeeLink('Samsung U28E590D');

        $I->amOnPage(self::BACKEND_PRODUCT_PATH);
        $I->selectOption('Product[status]', 'Не доступен');
        $I->wait(1);
        $I->seeLink('Dell U2415');
        $I->dontSeeLink('A4Tech B314 Black USB');
        $I->dontSeeLink('Samsung U28E590D');
        $I->dontSeeLink('Dell U2715H');
    }

    public function tryToTestBackendProductView(WebGuy $I, $scenario)
    {
        $I->wantToTest('product detail view page');

        $I = new UserSteps($scenario);
        $I->loginAsAdminAndGoToThePanel(CommonPage::TEST_USER_NAME, CommonPage::TEST_PASSWORD);
        $I->am('administrator');

        $I->amOnPage(self::BACKEND_PRODUCT_PATH . '/view/1');

        $I->see('Просмотр товара', 'h1');
        $I->see('«Dell U2715H»', 'small');

        $I->expectTo('see sidebar menu');
        $I->seeLink('Все товары');
        $I->seeLink('Добавить товар');
        $I->seeLink('Изменить товар');
        $I->seeLink('Просмотреть товар');
        $I->seeLink('Удалить товар');

        $I->expectTo('see product details table');
        $I->seeElement('table', ['class' => 'detail-view table table-striped table-condensed']);
        $I->see('Тип атрибута', 'th');
        $I->see('Мониторы', 'td');
        $I->see('Название', 'th');
        $I->see('Dell U2715H', 'td');
        $I->see('Цена', 'th');
        $I->see('38000.000', 'td');
        $I->see('Статус', 'th');
        $I->see('Доступен', 'td');
    }
    
    public function tryToTestBackendProductCreate(WebGuy $I, $scenario)
    {
        $I->wantTo('create product');

        $I = new UserSteps($scenario);
        $I->loginAsAdminAndGoToThePanel(CommonPage::TEST_USER_NAME, CommonPage::TEST_PASSWORD);
        $I->am('administrator');

        $I->amOnPage(self::BACKEND_PRODUCT_PATH . '/create');

        $I->see('Товары', 'h1');
        $I->see('добавление', 'small');

        $I->expectTo('see sidebar menu');
        $I->seeLink('Все товары');
        $I->seeLink('Добавить товар');

        $I->expectTo('see required fields validation errors');
        $I->click('Добавить товар и закрыть');
        $I->see('Необходимо заполнить поле «Название»', '.error');
        $I->see('Необходимо заполнить поле «Алиас»', '.error');

        $I->fillField('Product[sku]', 'TST6');
        $I->seeOptionIsSelected('Product[status]', 'Доступен');
        $I->selectOption('Product[category_id]', 'Клавиатуры');
        $I->selectOption('Product[producer_id]', 'A4Tech');
        $I->fillField('Product[name]', 'A4Tech Bloody B740 White USB');
        $I->wait(1);
        $I->seeInField('Product[slug]', 'a4tech-bloody-b740-white-usb');
        $I->fillField('Product[price]', 7000);
        $I->fillField('Product[discount]', 5);

        $I->click('//*[@id="content"]/ul[@class="nav nav-tabs"]/li[2]/a');
        $I->selectOption('Product[type_id]', 'Клавиатуры');
        $I->wait(1);
        $I->see('Тип клавиатуры', 'label');
        $I->selectOption('Attribute[3]', 'механическая');

        $I->click('Склад');
        $I->seeOptionIsSelected('Product[in_stock]', 'В наличии');
        $I->fillField('Product[quantity]', 1);
        $I->fillField('Product[length]', 101);
        $I->fillField('Product[width]', 102);
        $I->fillField('Product[height]', 103);
        $I->fillField('Product[weight]', 104);

        $I->click('SEO');
        $I->fillField('Product[title]', 'A4Tech Bloody. Заголовок h1');
        $I->fillField('Product[meta_title]', 'A4Tech Bloody. Заголовок страницы');
        $I->fillField('Product[meta_keywords]', 'A4Tech Bloody. Meta-keywords');
        $I->fillField('Product[meta_description]', 'A4Tech Bloody. Meta-description');

        $I->click('Связанные товары');
        $I->see('Сначала необходимо сохранить товар.');

        $I->click('Добавить товар и закрыть');
        $I->seeInCurrentUrl(self::BACKEND_PRODUCT_PATH);
        $I->see('Запись добавлена!', '.alert-success');
        $I->seeLink('A4Tech Bloody B740 White USB');

        $I->amOnPage(self::BACKEND_PRODUCT_PATH . '/view/6');

        $I->see('Просмотр товара', 'h1');
        $I->see('«A4Tech Bloody B740 White USB»', 'small');

        $I->see('Тип атрибута', 'th');
        $I->see('Клавиатуры', 'td');
        $I->see('Название', 'th');
        $I->see('A4Tech Bloody B740 White USB', 'td');
        $I->see('Цена', 'th');
        $I->see('7000.000', 'td');
        $I->see('Статус', 'th');
        $I->see('Доступен', 'td');
        $I->see('Длина, м.', 'th');
        $I->see('101.000', 'td');
        $I->see('Ширина, м.', 'th');
        $I->see('102.000', 'td');
        $I->see('Высота, м.', 'th');
        $I->see('103.000', 'td');
        $I->see('Вес, кг.', 'th');
        $I->see('104.000', 'td');
        $I->see('Количество', 'th');
        $I->see('1', 'td');

        $I->amOnPage(self::FRONTEND_PRODUCT_PATH);
        $I->seeLink('A4Tech Bloody B740 White USB');
    }
    
    public function tryToTestBackendProductUpdate(WebGuy $I, $scenario)
    {
        $I->wantTo('update product');

        $I = new UserSteps($scenario);
        $I->loginAsAdminAndGoToThePanel(CommonPage::TEST_USER_NAME, CommonPage::TEST_PASSWORD);
        $I->am('administrator');

        $I->amOnPage(self::FRONTEND_PRODUCT_PATH);
        $I->dontSeeLink('Dell U2415');

        $I->amOnPage(self::BACKEND_PRODUCT_PATH . '/update/3');
        $I->see('Редактирование товара', 'h1');
        $I->see('«Dell U2415»', 'small');
        $I->expectTo('see sidebar menu');
        $I->seeLink('Все товары');
        $I->seeLink('Добавить товар');
        $I->seeLink('Изменить товар');
        $I->seeLink('Просмотреть товар');
        $I->seeLink('Удалить товар');
        $I->seeOptionIsSelected('Product[status]', 'Не доступен');
        $I->selectOption('Product[status]', 'Доступен');
        $I->click('Сохранить товар и закрыть');
        $I->seeInCurrentUrl(self::BACKEND_PRODUCT_PATH);
        $I->see('Запись изменена!', '.alert-success');

        $I->amOnPage(self::FRONTEND_PRODUCT_PATH);
        $I->seeLink('Dell U2415');
    }
    
    public function tryToTestBackendProductDelete(WebGuy $I, $scenario)
    {
        $I->wantTo('delete product');

        $I = new UserSteps($scenario);
        $I->loginAsAdminAndGoToThePanel(CommonPage::TEST_USER_NAME, CommonPage::TEST_PASSWORD);
        $I->am('administrator');

        $I->amOnPage(self::BACKEND_PRODUCT_PATH);
        $I->see('Элементы 1—5 из 5.', '.summary');
        $I->seeLink('Dell P2214H');

        $I->amGoingTo('try delete product by direct request');
        $I->expectTo('see error');
        $I->amOnPage(self::BACKEND_PRODUCT_PATH . '/delete/2');
        $I->see('Неверный запрос. Пожалуйста, больше не повторяйте такие запросы', '.alert-danger');

        $I->amGoingTo('try delete product by post request');
        $I->amOnPage(self::BACKEND_PRODUCT_PATH);
        $I->executeJS('
            $.post(
                document.location.href + "/delete/2", 
                {"YUPE_TOKEN":yupeToken}
            );
        ');
        $I->wait(1);
        $I->reloadPage();
        $I->see('Элементы 1—4 из 4.', '.summary');
        $I->dontSeeLink('Dell P2214H');
    }
}