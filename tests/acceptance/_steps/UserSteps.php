<?php
namespace WebGuy;

class UserSteps extends \WebGuy
{
    public function login($email, $password)
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

    public function logout()
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


    public function changeEmail($email)
    {
        $I = $this;
        $I->login(\LoginPage::$userEmail, \LoginPage::$userPassword);
        $I->amOnPage(\EditProfilePage::URL);
        $I->fillField(\EditProfilePage::$emailField, $email);
        $I->see('Внимание! После смены e-mail адреса','.text-warning');
        $I->click('Сохранить профиль','.btn-primary');

        $I->see('Профиль обновлен!','.alert-success');
        $I->see('e-mail не подтвержден, проверьте почту!','.text-error');

        $I->seeInDatabase('yupe_user_user', array('email_confirm' => 0, 'email' => $email));
    }

}