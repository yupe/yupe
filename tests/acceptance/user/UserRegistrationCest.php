<?php
namespace tests\acceptance\user;

use \WebGuy;
use tests\acceptance\pages\LoginPage;
use tests\acceptance\pages\CommonPage;
use tests\acceptance\user\steps\UserSteps;
use tests\acceptance\pages\RegistrationPage;

class UserRegistrationCest
{
    public function testUserRegistrationAndActivation(WebGuy $I, $scenario)
    {
        $I->wantTo('Check registration and activation new user account...');

        $I->amOnPage(RegistrationPage::URL);
        $I->see(RegistrationPage::$buttonLabel);
        $I->seeInTitle('Регистрация');

        $I->wantTo('See form with empty fields...');
        $I->seeInField(RegistrationPage::$nickNameField, '');
        $I->seeInField(RegistrationPage::$emailField, '');
        $I->seeInField(RegistrationPage::$passwordField, '');
        $I->seeInField(RegistrationPage::$cpasswordField, '');
        $I->see(RegistrationPage::$buttonLabel);

        $I->wantTo('Test form validation...');

        $testNickName = 'testuser';
        $testEMail = 'testuser@yupe.local';
        $testPassword = 'testpassword';

        $I->fillField(RegistrationPage::$nickNameField, 'test-nick.name');
        $I->fillField(RegistrationPage::$emailField, 'test');
        $I->fillField(RegistrationPage::$passwordField, $testPassword);
        $I->fillField(RegistrationPage::$cpasswordField, '111');
        $I->click('button[type=submit]');

        $I->see('Email не является правильным E-Mail адресом', CommonPage::ERROR_CSS_CLASS);
        $I->see('Пароли не совпадают', CommonPage::ERROR_CSS_CLASS);
        $I->see(
            'Неверный формат поля "Имя пользователя" допустимы только буквы и цифры, от 2 до 20 символов',
            CommonPage::ERROR_CSS_CLASS
        );

        $I->wantTo('Test form with existing user name and email...');
        $I->fillField(RegistrationPage::$nickNameField, 'yupe');
        $I->fillField(RegistrationPage::$emailField, 'yupe@yupe.local');
        $I->fillField(RegistrationPage::$passwordField, $testPassword);
        $I->fillField(RegistrationPage::$cpasswordField, $testPassword);
        $I->click('button[type=submit]');
        $I->see('Имя пользователя уже занято', CommonPage::ERROR_CSS_CLASS);
        $I->see('Email уже занят', CommonPage::ERROR_CSS_CLASS);

        $I->wantTo('Test success registration...');
        $I->fillField(RegistrationPage::$nickNameField, $testNickName);
        $I->fillField(RegistrationPage::$emailField, $testEMail);
        $I->click('button[type=submit]');

        $I->see('Учетная запись создана! Проверьте Вашу почту!', CommonPage::SUCCESS_CSS_CLASS);
        $I->seeInCurrentUrl('login');
        // check that user is created
        $I->seeInDatabase(
            'yupe_user_user',
            [
                'email' => $testEMail,
                'access_level' => 0,
                'status' => 2,
                'email_confirm' => 0,
                'nick_name' => $testNickName,
            ]
        );
        //check that token is created
        $I->seeInDatabase('yupe_user_tokens', ['user_id' => 2, 'type' => 1, 'status' => 0]);

        $I->wantTo('Test that new user cant login without account activation...');
        $I->fillField(LoginPage::$emailField, $testEMail);
        $I->fillField(LoginPage::$passwordField, $testPassword);
        $I->click(CommonPage::LOGIN_BTN_CONTEXT);
        $I->see('Email или пароль введены неверно!', CommonPage::ERROR_CSS_CLASS);

        $I->wantTo('Test account activation...');
        $key = $I->grabFromDatabase('yupe_user_tokens', 'token', ['user_id' => 2, 'type' => 1, 'status' => 0]);
        $I->amOnPage(RegistrationPage::getActivateRoute(time()));
        $I->see(
            'Внимание! Возникла проблема с активацией аккаунта. Обратитесь к администрации сайта.',
            CommonPage::ERROR_CSS_CLASS
        );
        $I->seeInCurrentUrl('registration');

        $I->amOnPage(RegistrationPage::getActivateRoute($key));
        $I->see('Вы успешно активировали аккаунт! Теперь Вы можете войти!', CommonPage::SUCCESS_CSS_CLASS);
        // check user
        $I->seeInDatabase(
            'yupe_user_user',
            [
                'email' => $testEMail,
                'access_level' => 0,
                'status' => 1,
                'email_confirm' => 1,
                'nick_name' => $testNickName,
            ]
        );
        //check  token
        $I->dontSeeInDatabase('yupe_user_tokens', ['user_id' => 2, 'type' => 1, 'status' => 0]);

        $I->wantTo('Test login with new account...');
        $I = new UserSteps($scenario);
        $I->login($testEMail, $testPassword);
        $I->dontSeeLink('Панель управления');
    }
}
