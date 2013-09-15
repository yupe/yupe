<?php
namespace WebGuy;

class UserSteps extends \WebGuy
{
    function login($email, $password)
    {
        $I = $this;
        $I->amOnPage(\LoginPage::$URL);
        $I->wantTo('Check form with wrong data...');
        $I->fillField(\LoginPage::$emailField, $email);
        $I->fillField(\LoginPage::$passwordField, $password);
        $I->click('Войти', '.btn-primary');
        $I->dontSee('Email или пароль введены неверно!', '.alert-error');
        $I->see('Вы успешно авторизовались!','.alert-success');
        $I->seeLink('Панель управления');
        $I->seeLink(\LogoutPage::$linkLabel);
    }

    function logout()
    {
        $I = $this;
        $I->amOnPage('/');
        $I->seeLink(\LogoutPage::$linkLabel);
        $I->seeLink('Панель управления');
        $I->click(\LogoutPage::$linkLabel);
        $I->dontSeeLink(\LogoutPage::$linkLabel);
        $I->dontSeeLink('Панель управления');
        $I->seeLink('Войти');
    }
}