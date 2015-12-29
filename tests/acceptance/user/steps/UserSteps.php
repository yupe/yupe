<?php
namespace tests\acceptance\user\steps;

use \WebGuy;
use tests\acceptance\pages\LoginPage;
use tests\acceptance\pages\CommonPage;
use tests\acceptance\pages\LogoutPage;
use tests\acceptance\pages\EditProfilePage;

class UserSteps extends WebGuy
{
    public function login($email, $password)
    {
        $I = $this;
        $I->amOnPage(LoginPage::$URL);
        $I->wantTo('Check success login...');
        $I->fillField(LoginPage::$emailField, $email);
        $I->fillField(LoginPage::$passwordField, $password);
        $I->click(CommonPage::LOGIN_BTN_CONTEXT);
        $I->dontSee('Email или пароль введены неверно!', CommonPage::ERROR_CSS_CLASS);
        $I->see('Вы успешно авторизовались!', CommonPage::SUCCESS_CSS_CLASS);
    }

    public function logout()
    {
        $I = $this;
        $I->amOnPage('/ru/');
        $I->seeLink(LogoutPage::$linkLabel);
        $I->seeLink('Панель управления');
        $I->amOnPage(LogoutPage::$URL);
        $I->dontSeeLink(LogoutPage::$linkLabel);
        $I->dontSeeLink('Панель управления');
        $I->seeLink(CommonPage::LOGIN_LABEL);
    }

    public function changeEmail($email)
    {
        $I = $this;
        $I->login(LoginPage::$userEmail, LoginPage::$userPassword);
        $I->amOnPage(EditProfilePage::URL);
        $I->click('Изменить email');
        $I->seeInCurrentUrl('/profile/email');
        $I->fillField('ProfileEmailForm[email]', $email);
        $I->see('Внимание! После смены e-mail адреса', '.alert-warning');
        $I->click('Изменить email');
        $I->seeInCurrentUrl('/profile');
        $I->see('Вам необходимо продтвердить новый e-mail, проверьте почту!', CommonPage::SUCCESS_CSS_CLASS);
        $I->seeInDatabase('yupe_user_user', ['email_confirm' => 0, 'email' => $email]);
        //check token
        $I->seeInDatabase('yupe_user_tokens', ['user_id' => 1, 'type' => 3, 'status' => 0]);
    }

    public function loginAsAdminAndGoToThePanel($email, $password)
    {
        $I = $this;
        $this->login($email, $password);
        $I->am('admin');
        $I->amOnPage(CommonPage::PANEL_URL);
        $I->see(CommonPage::PANEL_LABEL, 'h1');
    }

}
