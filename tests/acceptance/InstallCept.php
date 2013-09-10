<?php
$I = new WebGuy($scenario);
$I->wantTo('Test Yupe! installation process!');
$I->amOnPage('/');

// begin install
$I->see('Добро пожаловать!','h1');
$I->see('Шаг 1 из 8 : "Приветствие!','span');
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

