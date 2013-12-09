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
        $I->amOnPage('/ru/');
        $I->seeLink(\LogoutPage::$linkLabel);
        $I->seeLink('Панель управления');
        $I->amOnPage(\LogoutPage::$URL);
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
        $I->see('Вам необходимо продтвердить новый e-mail, проверьте почту!',\CommonPage::SUCCESS_CSS_CLASS);      
        $I->seeInDatabase('yupe_user_user', array('email_confirm' => 0, 'email' => $email));
        //check token
        $I->seeInDatabase('yupe_user_tokens', array('user_id' => 1,'type' => 3,'status' => 0));
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