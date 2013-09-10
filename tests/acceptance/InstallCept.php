<?php
$I = new WebGuy($scenario);
$I->wantTo('Test Yupe! installation process!');
$I->amOnPage('/');


$I->wantTo('Test begin install!');
// begin install
$I->seeInTitle('Юпи! Установка Юпи!');
$I->see('Добро пожаловать!','h1');
$I->see('Шаг 1 из 8 : "Приветствие!','span');

// check external link
//$I->seeLink('amyLabs','http://amylabs.ru/?from=yupe-install');
//$I->seeLink('Форум','http://yupe.ru/talk/?from=login');
//$I->seeLink('http://yupe.ru','http://yupe.ru?from=install');

$I->seeLink('Начать установку >');

// environment check
$I->click('Начать установку >');
$I->seeInCurrentUrl('environment');
$I->dontSee('Дальнейшая установка невозможна, пожалуйста, исправьте ошибки!','.alert-error');
$I->see('Шаг 2 из 8 : "Проверка окружения!','span');
$I->seeLink('< Назад');
$I->seeLink('Продолжить >');

// requirements check
$I->click('Продолжить >');
$I->seeInCurrentUrl('requirements');
$I->dontSee('Дальнейшая установка невозможна, пожалуйста, исправьте ошибки!','.alert-error');
$I->see('Шаг 3 из 8 : "Проверка системных требований','span');
$I->seeLink('< Назад');
$I->seeLink('Продолжить >');

// dbsettings check
$I->click('Продолжить >');
$I->seeInCurrentUrl('dbsettings');
$I->see('Шаг 4 из 8 : "Соединение с базой данных','span');

// check db settings form
// mysql checked
$I->selectOption('InstallForm[dbType]','1');
$I->seeInField('InstallForm[host]','localhost');
$I->seeInField('InstallForm[port]','3306');
$I->seeInField('InstallForm[dbName]','');
$I->dontSeeCheckboxIsChecked('InstallForm[createDb]');
$I->cantSeeInField('InstallForm[tablePrefix]','_yupe');
$I->seeInField('InstallForm[dbUser]','');
$I->seeInField('InstallForm[dbPassword]','');
$I->seeInField('InstallForm[socket]','');

$I->seeLink('< Назад');
$I->see('Проверить подключение и продолжить >');

$I->click('Проверить подключение и продолжить >');
$I->see('Необходимо исправить следующие ошибки:','.alert-error');
$I->see('Необходимо заполнить поле «Название базы данных».','.alert-error');
$I->see('Необходимо заполнить поле «Пользователь».','.alert-error');

$I->fillField('InstallForm[dbName]','yupetest');
$I->fillField('InstallForm[dbUser]','root');
$I->fillField('InstallForm[dbPassword]','root');
$I->checkOption('InstallForm[createDb]');

$I->click('Проверить подключение и продолжить >');
$I->dontSee('Не удалось создать БД!','.alert-error');

$I->see('Шаг 5 из 8 : "Установка модулей');
$I->seeInCurrentUrl('modulesinstall');
$I->see('Доступно модулей:','.alert-success');
$I->see('20','.label-info');
$I->see('7','.label-info');

$links = array('Рекомендованные','Только основные', 'Все');

foreach($links as $link) {
    $I->see($link,'.btn-info');
}

$I->seeLink('< Назад');
$I->see('Продолжить >');

$I->click('Продолжить >');
$I->see('Будет установлено','h4');
$I->click('Продолжить >','.modal-footer');

$I->seeInCurrentUrl('modulesinstall');
$I->see('Шаг 5 из 8 : "Установка модулей','span');
$I->see('Идет установка модулей...','h1');
$I->see('Журнал установки','h3');











