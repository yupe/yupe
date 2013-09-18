<?php
use \WebGuy;

class UserLoginCest
{
    public function testLoginPage(WebGuy $I, $scenario)
    {
        $I->amOnPage(LoginPage::$URL);
        $I->wantTo('Check login form elements...');
        $I->seeInTitle('Войти');
        $I->seeLink('Забыли пароль?');
        $I->see('Войти');
        $I->see('Запомнить меня');
        $I->dontSeeCheckboxIsChecked('LoginForm[remember_me]');
        $I->seeLink('Регистрация');
        $I->seeInField(LoginPage::$emailField, '');
        $I->seeInField(LoginPage::$passwordField, '');

        $I->amOnPage(LoginPage::$URL);
        $I->wantTo('Check form with wrong data format...');
        $I->fillField(LoginPage::$emailField, 'test');
        $I->fillField(LoginPage::$passwordField, 'test');
        $I->click('Войти', '.btn-primary');
        $I->see('Email не является правильным E-Mail адресом.', '.alert-error');

        $I->amOnPage(LoginPage::$URL);
        $I->wantTo('Check form with wrong data...');
        $I->fillField(LoginPage::$emailField, 'test@test.ru');
        $I->fillField(LoginPage::$passwordField, 'test');
        $I->click('Войти', '.btn-primary');
        $I->see('Email или пароль введены неверно!', '.alert-error');

        $I = new WebGuy\UserSteps($scenario);
        $I->login('yupe@yupetest.ru','111111');
    }
}