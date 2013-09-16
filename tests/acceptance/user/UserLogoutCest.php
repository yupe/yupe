<?php
use \WebGuy;

class UserLogoutCest
{
    public function testLogout(WebGuy $I, $scenario)
    {
        $I->seeInDatabase('yupe_user_user', array('email' => \LoginPage::$userEmail));
        $I = new WebGuy\UserSteps($scenario);
        $I->login(\LoginPage::$userEmail,\LoginPage::$userPassword);
        $I->logout();
    }
}