<?php
namespace tests\acceptance\user;

use \WebGuy;
use tests\acceptance\pages\LoginPage;
use tests\acceptance\pages\CommonPage;
use tests\acceptance\user\steps\UserSteps;

class UserLoginCest
{
    public function testLoginPage(WebGuy $I, $scenario)
    {
        $I->amOnPage(LoginPage::$URL);
        $I->wantTo('Check login form elements...');
        $I->seeInTitle(CommonPage::LOGIN_LABEL);
        $I->seeLink('Забыли пароль?');
        $I->see(CommonPage::LOGIN_LABEL);
        $I->see('Запомнить меня');
        $I->dontSeeCheckboxIsChecked(LoginPage::$rememberMeField);
        $I->seeLink('Регистрация');
        $I->seeInField(LoginPage::$emailField, '');
        $I->seeInField(LoginPage::$passwordField, '');

        $I->amOnPage(LoginPage::$URL);
        $I->wantTo('Check form with wrong data...');
        $I->fillField(LoginPage::$emailField, 'test@test.ru');
        $I->fillField(LoginPage::$passwordField, 'testpass');
        $I->click(CommonPage::LOGIN_BTN_CONTEXT);
        $I->see('Email или пароль введены неверно!', CommonPage::ERROR_CSS_CLASS);

        $I = new UserSteps($scenario);
        $I->login('yupe@yupe.local', 'testpassword');
    }
}
