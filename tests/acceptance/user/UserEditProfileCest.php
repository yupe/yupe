<?php
namespace user;
use \WebGuy;

class UserEditProfileCest
{
    public function testEditUserProfile(WebGuy $I, $scenario)
    {
        $I->dontSeeLink(\EditProfilePage::URL);
        $I->amOnPage(\EditProfilePage::URL);
        $I->seeInCurrentUrl('login');
        $I->wantTo('Test user profile form...');

        $I = new WebGuy\UserSteps($scenario);
        $I->login(\LoginPage::$userEmail, \LoginPage::$userPassword);
        $I->amOnPage(\EditProfilePage::URL);
        $I->see('E-Mail проверен','.text-success');
        $I->seeInTitle('Профиль пользователя');
        $I->seeInField(\EditProfilePage::$emailField,\LoginPage::$userEmail);
        $I->see('Сохранить профиль',\CommonPage::BTN_PRIMARY_CSS_CLASS);

        $I->wantTo('Test change user email...');
        $I = new WebGuy\UserSteps($scenario);
        $I->logout();
        $I->changeEmail('test2@yupe.local');
    }
}