<?php
namespace user;
use \WebGuy;

class UserRegistrationCest
{
    public function testUserRegistrationAndActivation(WebGuy $I)
    {
        $I->wantTo('Check registration and activation new user account...');

        $I->amOnPage(\RegistrationPage::URL);
        $I->see(\RegistrationPage::$buttonLabel);
        $I->seeInTitle('Регистрация');
    }
}