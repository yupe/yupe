<?php
use \WebGuy;

class UserRecoveryPasswordCest
{
    public function testRecoveryPasswordForm(WebGuy $I)
    {
        $I->amOnPage(LoginPage::$URL);
        $I->click('Забыли пароль?');
        $I->seeInCurrentUrl('recovery');
        $I->seeInField(RecoveryPage::$emailField, '');
        $I->see(RecoveryPage::$buttonLabel);
    }

    public function testRecoveryPasswordFormEmptyEmail(WebGuy $I)
    {
        $I->amOnPage(RecoveryPage::$URL);
        $I->fillField(RecoveryPage::$emailField, 'test');
        $I->click(RecoveryPage::$buttonLabel);
        $I->see('Email не является правильным E-Mail адресом.', '.alert-error');
        $I->see('Введите email, указанный при регистрации', '.help-block');
    }

    public function testRecoveryPasswordFormWrongEmail(WebGuy $I)
    {
        $I->amOnPage(RecoveryPage::$URL);
        $I->fillField(RecoveryPage::$emailField, 'test@test.ru');
        $I->click(RecoveryPage::$buttonLabel);
        $I->see('Email "test@test.ru" не найден или пользователь заблокирован', '.alert-error');
    }

    public function testRecoveryPasswordSuccess(WebGuy $I)
    {
        $I->amOnPage(RecoveryPage::$URL);
        $I->fillField(RecoveryPage::$emailField, 'yupe@yupetest.ru');
        $I->click(RecoveryPage::$buttonLabel);
        $I->see('На указанный email отправлено письмо с инструкцией по восстановлению пароля!', '.alert-success');
        $I->seeInCurrentUrl('login');
    }
}