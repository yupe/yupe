<?php
namespace user;
use \WebGuy;

class UserRegistrationCest
{
    public function testUserRegistrationAndActivation(WebGuy $I, $scenario)
    {
        $I->wantTo('Check registration and activation new user account...');

        $I->amOnPage(\RegistrationPage::URL);
        $I->see(\RegistrationPage::$buttonLabel);
        $I->seeInTitle('Регистрация');

        $I->wantTo('See form with empty fields...');
        $I->seeInField('RegistrationForm[nick_name]','');
        $I->seeInField('RegistrationForm[email]','');
        $I->seeInField('RegistrationForm[password]','');
        $I->seeInField('RegistrationForm[cPassword]','');
        $I->see(\RegistrationPage::$buttonLabel);

        $I->wantTo('Test form validation...');

        $testNickName = 'testuser';
        $testEMail = 'testuser@test.ru';
        $testPassword = 'testpassword';

        $I->fillField('RegistrationForm[nick_name]', 'test-nick.name');
        $I->fillField('RegistrationForm[email]', 'test');
        $I->fillField('RegistrationForm[password]',$testPassword);
        $I->fillField('RegistrationForm[cPassword]','111');
        $I->click(\RegistrationPage::$buttonLabel);
        $I->see('Email не является правильным E-Mail адресом','.alert-error');
        $I->see('Пароли не совпадают','.alert-error');
        $I->see('Неверный формат поля "Имя пользователя" допустимы только буквы и цифры, от 2 до 20 символов','.alert-error');

        $I->wantTo('Test form with existing user name and email...');
        $I->fillField('RegistrationForm[nick_name]', 'yupe');
        $I->fillField('RegistrationForm[email]', 'yupe@yupetest.ru');
        $I->fillField('RegistrationForm[password]',$testPassword);
        $I->fillField('RegistrationForm[cPassword]',$testPassword);
        $I->click(\RegistrationPage::$buttonLabel);
        $I->see('Имя пользователя уже занято','.alert-error');
        $I->see('Email уже занят','.alert-error');

        $I->wantTo('Test success registration...');
        $I->fillField('RegistrationForm[nick_name]', $testNickName);
        $I->fillField('RegistrationForm[email]', $testEMail);
        $I->click(\RegistrationPage::$buttonLabel);
        $I->see('Учетная запись создана! Проверьте Вашу почту!','.alert-success');
        $I->seeInCurrentUrl('login');
        $I->seeInDatabase('yupe_user_user', array('email' => $testEMail, 'access_level' => 0, 'status' => 2, 'email_confirm' => 0, 'nick_name' => $testNickName));

        $I->wantTo('Test that new user cant login without account activation...');
        $I->fillField(\LoginPage::$emailField, $testEMail);
        $I->fillField(\LoginPage::$passwordField, $testPassword);
        $I->click('Войти', '.btn-primary');
        $I->see('Email или пароль введены неверно!','.alert-error');

        $I->wantTo('Test account activation...');
        $key = $I->grabFromDatabase('yupe_user_user','activate_key', array('email' => $testEMail, 'access_level' => 0, 'status' => 2, 'email_confirm' => 0, 'nick_name' => $testNickName));
        $I->amOnPage('/user/account/activate/key/'.time());
        $I->see('Ошибка активации! Возможно данный аккаунт уже активирован! Попробуете зарегистрироваться вновь?','.alert-error');
        $I->seeInCurrentUrl('/registration');

        $I->amOnPage("/user/account/activate/key/{$key}");
        $I->see('Вы успешно активировали аккаунт! Теперь Вы можете войти!','.alert-success');
        $I->seeInDatabase('yupe_user_user', array('email' => $testEMail, 'access_level' => 0, 'status' => 1, 'email_confirm' => 1, 'nick_name' => $testNickName));

        $I->wantTo('Test login with new account...');
        $I = new WebGuy\UserSteps($scenario);
        $I->login($testEMail, $testPassword);
        $I->dontSeeLink('Панель управления');
    }
}