<?php
namespace user;
use \WebGuy;

class UserEditProfileCest
{
    public function testProfileFormRender(WebGuy $I, $scenario)
    {
        $I->dontSeeLink(\EditProfilePage::URL);
        $I->amOnPage(\EditProfilePage::URL);
        $I->seeInCurrentUrl('login');

        $I = new WebGuy\UserSteps($scenario);
        $I->login(\LoginPage::$userEmail, \LoginPage::$userPassword);
        $I->amOnPage(\EditProfilePage::URL);
        $I->see('E-Mail проверен','.text-success');
        $I->seeInTitle('Профиль пользователя');
        $I->seeInField(\EditProfilePage::$emailField,\LoginPage::$userEmail);
        $I->see('Сохранить профиль','.btn-primary');
    }

    public function testChangeEmail(WebGuy $I, $scenario)
    {
        $I = new WebGuy\UserSteps($scenario);
        $I->changeEmail('test2@testyupe.ru');
    }
}