<?php
namespace tests\acceptance\install;

use \WebGuy;
use tests\acceptance\pages\CommonPage;

class InstallCest
{
    public function _before(WebGuy $I)
    {
        copy('protected/modules/install/install/install.php', 'protected/config/modules/install.php');
    }
    /**
     * @group install
     */
    public function testInstall(WebGuy $I)
    {
        $I->amGoingTo('test Yupe! installation process!');
        $I->amOnPage('/install/default/index');

        // begin install
        $I->seeInTitle('Yupe! установка Yupe!');
        $I->see('Добро пожаловать!', 'h1');
        $I->see('Шаг 1 из 8 : "Приветствие!', 'span');
        $I->see('русский');
        $I->see('английский');

        // check external link
        $I->seeLink('amylabs');
        $I->seeLink('форум');

        $I->click('русский');

        $I->amGoingTo('test change language');
        $I->amOnPage('/en/install/default/environment');
        $I->see('On this step Yupe checks access right for needed directories');
        $I->amOnPage('/ru/install/default/environment');
        $I->see('На данном этапе Юпи! проверяет права доступа для всех необходимых каталогов.');

        $I->amOnPage('/en/install/default/environment');
        $I->see('On this step Yupe checks access right for needed directories');
        $I->amOnPage('/ru/install/default/environment');
        $I->see('На данном этапе Юпи! проверяет права доступа для всех необходимых каталогов.');

        // environment check
        $I->seeInCurrentUrl('environment');
        $I->dontSee('Дальнейшая установка невозможна, пожалуйста, исправьте ошибки!', CommonPage::ERROR_CSS_CLASS);
        $I->see('Шаг 2 из 8 : "Проверка окружения!', 'span');
        $I->seeLink('< Назад');
        $I->seeLink('Продолжить >');

        // requirements check
        $I->click('Продолжить >');
        $I->seeInCurrentUrl('requirements');
        $I->dontSee('Дальнейшая установка невозможна, пожалуйста, исправьте ошибки!', CommonPage::ERROR_CSS_CLASS);
        $I->see('Шаг 3 из 8 : "Проверка системных требований', 'span');
        $I->seeLink('< Назад');
        $I->seeLink('Продолжить >');

        // dbsettings check
        $I->click('Продолжить >');
        $I->seeInCurrentUrl('dbsettings');
        $I->see('Шаг 4 из 8 : "Соединение с базой данных', 'span');

        // check db settings form
        // mysql checked
        $I->selectOption('InstallForm[dbType]', '1');
        $I->seeInField('InstallForm[host]', '127.0.0.1');
        $I->seeInField('InstallForm[port]', '3306');
        $I->seeInField('InstallForm[dbName]', '');
        $I->dontSeeCheckboxIsChecked('InstallForm[createDb]');
        $I->cantSeeInField('InstallForm[tablePrefix]', '_yupe');
        $I->seeInField('InstallForm[dbUser]', '');
        $I->seeInField('InstallForm[dbPassword]', '');
        $I->seeInField('InstallForm[socket]', '');

        $I->seeLink('< Назад');
        $I->see('Проверить подключение и продолжить >');

        $I->click('Проверить подключение и продолжить >');
        $I->see('Необходимо исправить следующие ошибки:', CommonPage::ERROR_CSS_CLASS);
        $I->see('Необходимо заполнить поле «Название базы данных».', CommonPage::ERROR_CSS_CLASS);
        $I->see('Необходимо заполнить поле «Пользователь».', CommonPage::ERROR_CSS_CLASS);

        $dbConfig = $I->getDbConfig();
        $I->fillField('InstallForm[dbName]', $dbConfig["dbname"]);
        $I->fillField('InstallForm[dbUser]', $dbConfig["user"]);
        $I->fillField('InstallForm[dbPassword]', $dbConfig["password"]);

        $I->click('Проверить подключение и продолжить >');
        $I->dontSee('Не удалось создать БД!', CommonPage::ERROR_CSS_CLASS);

        $I->see('Шаг 5 из 8 : "Установка модулей');
        $I->seeInCurrentUrl('modulesinstall');
        $I->see('Доступно модулей:', CommonPage::SUCCESS_CSS_CLASS);
        $I->see('34', '.label-info');
        $I->see('10', '.label-info');

        $links = ['Интернет-магазин', 'Только основные', 'Все'];

        foreach ($links as $link) {
            $I->see($link, '.btn-info');
        }

        $I->seeLink('< Назад');
        $I->see('Продолжить >');

        $I->click('Все');

//        $I->click('Продолжить >');
        $I->executeJS("$('#modules-modal').modal('toggle');");
        $I->waitForElementVisible('#modules-modal', 5);

        $I->see('Будет установлено', 'h4');
        $I->see('Отмена');
        $I->click('Продолжить >', '.modal-footer');

        $I->seeInCurrentUrl('modulesinstall');
        $I->see('Шаг 5 из 8 : "Установка модулей', 'span');
        $I->see('Идет установка модулей...', 'h1');
        $I->see('Журнал установки', 'h3');

        $I->wait(30);
        $I->see('34 / 34');
        $I->see('Установка завершена', 'h4');
        $I->see('Поздравляем, установка выбранных вами модулей завершена.');
        $I->see('Смотреть журнал');

        //check admin create
        $I->click('Продолжить >', '.modal-footer');
        $I->seeInCurrentUrl('createuser');
        $I->see('Шаг 6 из 8 : "Создание учетной записи администратора', 'span');
        $I->seeInField('InstallForm[userName]', '');
        $I->seeInField('InstallForm[userEmail]', '');
        $I->seeInField('InstallForm[userPassword]', '');
        $I->seeInField('InstallForm[cPassword]', '');
        $I->seeLink('< Назад');
        $I->see('Продолжить >');

        //check form validation
        $I->fillField('InstallForm[userName]', 'yupe');
        $I->fillField('InstallForm[userEmail]', 'yupe');
        $I->fillField('InstallForm[userPassword]', 'testpassword');
        $I->fillField('InstallForm[cPassword]', 'testpass');
        $I->click('Продолжить >');
        $I->see('Необходимо исправить следующие ошибки', CommonPage::ERROR_CSS_CLASS);
        $I->see('Пароли не совпадают!', CommonPage::ERROR_CSS_CLASS);
        $I->see('Email не является правильным E-Mail адресом.', CommonPage::ERROR_CSS_CLASS);

        $I->fillField('InstallForm[userEmail]', 'yupe@yupe.local');
        $I->fillField('InstallForm[cPassword]', 'testpassword');
        $I->click('Продолжить >');
        $I->dontSee('Необходимо исправить следующие ошибки', CommonPage::ERROR_CSS_CLASS);

        $I->seeInCurrentUrl('sitesettings');
        $I->see('Шаг 7 из 8 : "Настройки проекта"', 'span');
        $I->selectOption('InstallForm[theme]', 'default');
        $I->seeInField('InstallForm[siteName]', 'Юпи!');
        $I->seeInField('InstallForm[siteDescription]', 'Юпи! - самый простой способ создать сайт на Yii!');
        $I->seeInField('InstallForm[siteKeyWords]', 'Юпи!, yupe, цмс, yii');
        $I->seeInField('InstallForm[siteEmail]', 'yupe@yupe.local');
        $I->seeLink('< Назад');
        $I->see('Продолжить >');

        // check finish
        $I->click('Продолжить >');
        $I->seeInCurrentUrl('finish');
        $I->see('Шаг 8 из 8 : "Окончание установки', 'span');
        $I->see('Поздравляем, установка "Юпи!" завершена!', 'h1');
        $I->seeLink('ПЕРЕЙТИ НА САЙТ');
        $I->seeLink('ПЕРЕЙТИ В ПАНЕЛЬ УПРАВЛЕНИЯ');

        // check site
        $I->amOnPage('/ru/site/index');
        $I->see('Поздравляем!', 'h1');
    }
}
