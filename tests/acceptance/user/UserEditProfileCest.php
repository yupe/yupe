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
        $I->login(\LoginPage::$userEmail, \LoginPage::$userPassword);
        $I->amOnPage(\EditProfilePage::URL);
        $testEmail = 'test2@testyupe.ru';
        $I->fillField(\EditProfilePage::$emailField, $testEmail);
        $I->see('Внимание! После смены e-mail адреса','.text-warning');
        $I->click('Сохранить профиль','.btn-primary');

        $I->see('Профиль обновлен!','.alert-success');
        $I->see('e-mail не подтвержден, проверьте почту!','.text-error');

        $I->seeInDatabase('yupe_user_user', array('email_confirm' => 0, 'email' => $testEmail));

    }
}