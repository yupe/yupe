<?php
use \WebGuy;

class UserLogoutCest
{
    public function testLogout(WebGuy $I, $scenario)
    {
        $I = new WebGuy\UserSteps($scenario);
        $I->login(\LoginPage::$userEmail,\LoginPage::$userPassword);
        $I->logout();
    }
}