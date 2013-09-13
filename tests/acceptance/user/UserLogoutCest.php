<?php
use \WebGuy;

class UserLogoutCest
{
    public function testLogout(WebGuy $I)
    {
        $I->amOnPage(LoginPage::$URL);
        $I->wantTo('Check form with wrong data...');
        $I->fillField(LoginPage::$emailField, 'yupe@yupetest.ru');
        $I->fillField(LoginPage::$passwordField, '111111');
        $I->click('Войти', '.btn-primary');
        $I->dontSee('Email или пароль введены неверно!', '.alert-error');
        $I->see('Вы успешно авторизовались!','.alert-success');
        $I->seeLink('Панель управления');
        $I->seeLink('Выйти');

        //

        $I->amOnPage('/');
        $I->seeLink('Выйти');
        $I->seeLink('Панель управления');
        $I->click('Выйти');
        $I->dontSeeLink('Выйти');
        $I->dontSeeLink('Панель управления');
        $I->seeLink('Войти');
    }
}