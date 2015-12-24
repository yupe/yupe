<?php
namespace tests\acceptance\backend;

use \WebGuy;
use tests\acceptance\pages\CommonPage;
use tests\acceptance\user\steps\UserSteps;

class MainBackendCest
{
    public function tryToTestMainBackend(WebGuy $I, $scenario)
    {
        $I = new UserSteps($scenario);
        $I->am('guest user');
        $I->amGoingTo('try access to admin area');
        $I->amOnPage(CommonPage::PANEL_URL . 'login');
        $I->seeInCurrentUrl('/backend/login');
        $I->see('Пожалуйста, авторизуйтесь');
        $I->fillField('LoginForm[password]', 'wrong password');
        $I->fillField('LoginForm[email]', CommonPage::TEST_USER_NAME);
        $I->click('Войти');
        $I->see('Email или пароль введены неверно!', CommonPage::ERROR_CSS_CLASS);

        $I->fillField('LoginForm[password]', CommonPage::TEST_PASSWORD);
        $I->click('Войти');
        //$I->see('Вы успешно авторизовались!', CommonPage::SUCCESS_CSS_CLASS);
        $I->amOnPage(CommonPage::PANEL_URL);
        $I->see('Панель управления "Юпи!"', 'h1');

        //simple check all modules

        $I->amGoingTo('simple test all modules page');

        $I->amOnPage('/backend/news/news');
        $I->see('Новости', 'h1');

        $I->amOnPage('/backend/page/page');
        $I->see('Страницы', 'h1');

        $I->amOnPage('/backend/image/image');
        $I->see('Изображения', 'h1');

        $I->amOnPage('/backend/gallery/gallery');
        $I->see('Галереи', 'h1');

        $I->amOnPage('/backend/comment/comment');
        $I->see('Комментарии', 'h1');

        $I->amOnPage('/backend/contentblock/contentBlock');
        $I->see('Блоки контента');

        $I->amOnPage('/backend/menu/menu');
        $I->see('Меню', 'h1');

        $I->amOnPage('/backend/menu/menuitem');
        $I->see('Пункты меню');

        $I->amOnPage('/backend/dictionary/dictionary');
        $I->see('Справочники', 'h1');

        $I->amOnPage('/backend/dictionary/dictionaryData');
        $I->see('Значения справочников', 'h1');

        $I->amOnPage('/backend/category/category');
        $I->see('Категории', 'h1');

        $I->amOnPage('/backend/queue/queue');
        $I->see('Задания', 'h1');

        $I->amOnPage('/backend/mail/event');
        $I->see('Почтовые события', 'h1');

        $I->amOnPage('/backend/mail/template');
        $I->see('Почтовые шаблоны', 'h1');

        $I->amOnPage('/backend/feedback/feedback');
        $I->see('Сообщения', 'h1');

        $I->amOnPage('/backend/user/user');
        $I->see('Пользователи', 'h1');

        $I->amGoingTo('change backend language');
        $I->amOnPage('/en/backend');
        $I->see('Control panel "Yupe!"', 'h1');
        $I->amOnPage('/ru/backend');
        $I->see('Панель управления "Юпи!"', 'h1');
        $I->amOnPage('/en/backend');
        $I->see('Control panel "Yupe!"', 'h1');
        $I->amOnPage('/ru/backend');
        $I->see('Панель управления "Юпи!"', 'h1');

        $I->amGoingTo('change theme settings');
        $I->amOnPage('/backend/themesettings');
        $I->click('Сохранить настройки тем оформления');
        $I->see('Настройки темы успешно сохранены!', CommonPage::SUCCESS_CSS_CLASS);

        $I->amGoingTo('change module settings');
        $I->amOnPage('/backend/modulesettings?module=yupe');
        $I->fillField('siteDescription', 'Changed site description!');
        $I->click('Сохранить настройки модуля "Юпи!"');
        $I->see('Настройки модуля "Юпи!" сохранены!', CommonPage::SUCCESS_CSS_CLASS);
        $I->seeInField('siteDescription', 'Changed site description!');

        $I->amGoingTo('test modules page');
        $I->amOnPage('/backend/settings');
        $I->see('Модули', 'h1');
        $I->seeLink('Юпи! (yupe)', '/backend/settings');
        $I->seeLink('Пользователи (user)', '/backend/user/user');

        //$I->amGoingTo('disable catalog module');
        //$I->clickWithRightButton("[module='catalog']");
        //$I->see('Вы уверены, что хотите отключить модуль?','.modal-body');

    }
}
