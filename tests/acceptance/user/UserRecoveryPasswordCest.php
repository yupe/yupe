<?php
use \WebGuy;

class UserRecoveryPasswordCest
{
    public function testRecoveryPassword(WebGuy $I)
    {
        $I->amOnPage(LoginPage::$URL);
        $I->wantTo('Check recovery form...');

        $I->click('Забыли пароль?');
        $I->seeInCurrentUrl('recovery');
        $I->seeInField(RecoveryPage::$emailField, '');
        $I->see(RecoveryPage::$buttonLabel);

        $I->wantTo('Check recovery form with wrong email...');

        $I->fillField(RecoveryPage::$emailField, 'test');
        $I->click(RecoveryPage::$buttonLabel);
        $I->see('Email не является правильным E-Mail адресом.', '.alert-error');
        $I->see('Введите email, указанный при регистрации', '.help-block');

        $I->wantTo('Check recovery form with not existing email...');

        $I->fillField(RecoveryPage::$emailField, 'test@test.ru');
        $I->click(RecoveryPage::$buttonLabel);
        $I->see('Email "test@test.ru" не найден или пользователь заблокирован', '.alert-error');

        $I->wantTo('Check recovery form with valid data...');

        $I->fillField(RecoveryPage::$emailField, 'yupe@yupetest.ru');
        $I->click(RecoveryPage::$buttonLabel);
        $I->see('На указанный email отправлено письмо с инструкцией по восстановлению пароля!', '.alert-success');
        $I->seeInCurrentUrl('login');

        $I->seeInDatabase('yupe_user_recovery_password', array('user_id' => 1));
        $key = $I->grabFromDatabase('yupe_user_recovery_password','code', array('user_id' => 1));
        $I->amOnPage("/user/account/recoveryPassword/code/{$key}");
        $I->dontSeeInDatabase('yupe_user_recovery_password', array('user_id' => 1));
        $I->see('Новый пароль отправлен Вам на email!','.alert-success');
    }
}