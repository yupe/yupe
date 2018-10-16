<?php
namespace tests\acceptance\user;

use \WebGuy;
use tests\acceptance\pages\LoginPage;
use tests\acceptance\user\steps\UserSteps;

class UserLogoutCest
{
    public function testLogout(WebGuy $I, $scenario)
    {
        $I = new UserSteps($scenario);
        $I->login(LoginPage::$userEmail, LoginPage::$userPassword);
        $I->logout();
    }
}
