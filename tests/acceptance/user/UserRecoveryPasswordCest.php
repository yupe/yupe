<?php
namespace tests\acceptance\user;

use \WebGuy;
use tests\acceptance\pages\LoginPage;
use tests\acceptance\pages\CommonPage;
use tests\acceptance\pages\RecoveryPage;

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
        $I->see('Email не является правильным E-Mail адресом.', CommonPage::ERROR_CSS_CLASS);
        $I->see('Введите email, указанный при регистрации', '.help-block');

        $I->wantTo('Check recovery form with not existing email...');

        $I->fillField(RecoveryPage::$emailField, 'test@test.ru');
        $I->click(RecoveryPage::$buttonLabel);
        $I->see('Email "test@test.ru" не найден или пользователь заблокирован', CommonPage::ERROR_CSS_CLASS);

        $I->wantTo('Check recovery form with valid data...');

        $I->fillField(RecoveryPage::$emailField, 'yupe@yupe.local');
        $I->click(RecoveryPage::$buttonLabel);
        $I->see(
            'На указанный email отправлено письмо с инструкцией по восстановлению пароля!',
            CommonPage::SUCCESS_CSS_CLASS
        );
        $I->seeInCurrentUrl('login');

        $I->wantToTest('Failure password recovery');
        $I->amOnPage(RecoveryPage::getRecoveryRoute(time()));
        $I->see('Ошибка 404!');

        $I->seeInDatabase('yupe_user_tokens', ['user_id' => 1, 'type' => 2, 'status' => 0]);
        $key = $I->grabFromDatabase('yupe_user_tokens', 'token', ['user_id' => 1, 'type' => 2, 'status' => 0]);
        $I->amOnPage(RecoveryPage::getRecoveryRoute($key));

        $I->see('Восстановить пароль');
        $I->see('Изменить пароль');

        $I->fillField('ChangePasswordForm[password]', '11111111');
        $I->fillField('ChangePasswordForm[cPassword]', '11111111');
        $I->click('Изменить пароль');

        $I->seeInCurrentUrl(LoginPage::$URL);
        //$I->see('Успешное восстановение пароля!', \CommonPage::SUCCESS_CSS_CLASS);
        $I->dontSeeInDatabase('yupe_user_tokens', ['user_id' => 1, 'type' => 2, 'status' => 0]);
    }
}
