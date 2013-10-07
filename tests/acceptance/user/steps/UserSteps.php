<?php
namespace WebGuy;

class UserSteps extends \WebGuy
{
    public function login($email, $password)
    {
        $I = $this;
        $I->amOnPage(\LoginPage::$URL);
        $I->wantTo('Check success login...');
        $I->fillField(\LoginPage::$emailField, $email);
        $I->fillField(\LoginPage::$passwordField, $password);
        $I->click(\CommonPage::LOGIN_LABEL, \CommonPage::BTN_PRIMARY_CSS_CLASS);
        $I->dontSee('Email или пароль введены неверно!', \CommonPage::ERROR_CSS_CLASS);
        $I->see('Вы успешно авторизовались!',\CommonPage::SUCCESS_CSS_CLASS);
        $I->seeLink(\LogoutPage::$linkLabel);
    }

    public function logout()
    {
        $I = $this;
        $I->amOnPage('/');
        $I->seeLink(\LogoutPage::$linkLabel);
        $I->seeLink('Панель управления');
        $I->click(\LogoutPage::$linkLabel);
        $I->dontSeeLink(\LogoutPage::$linkLabel);
        $I->dontSeeLink('Панель управления');
        $I->seeLink(\CommonPage::LOGIN_LABEL);
    }


    public function changeEmail($email)
    {
        $I = $this;
        $I->login(\LoginPage::$userEmail, \LoginPage::$userPassword);
        $I->amOnPage(\EditProfilePage::URL);
        $I->fillField(\EditProfilePage::$emailField, $email);
        $I->see('Внимание! После смены e-mail адреса','.text-warning');
        $I->click('Сохранить профиль',\CommonPage::BTN_PRIMARY_CSS_CLASS);

        $I->see('Профиль обновлен!',\CommonPage::SUCCESS_CSS_CLASS);
        $I->see('e-mail не подтвержден, проверьте почту!','.text-error');

        $I->seeInDatabase('yupe_user_user', array('email_confirm' => 0, 'email' => $email));
    }

    public function loginAsAdminAndGoToThePanel($email, $password)
    {
        $I = $this;
        $this->login($email, $password);
        $I->am('admin');
        $I->amOnPage(\CommonPage::PANEL_URL);
        $I->see(\CommonPage::PANEL_LABEL,'h1');
    }

}