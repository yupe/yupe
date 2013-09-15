<?php
use \WebGuy;

class UserLogoutCest
{
    public function testLogout(WebGuy $I, $scenario)
    {
        $I = new WebGuy\UserSteps($scenario);
        $I->login('yupe@yupetest.ru', '111111');
        $I->logout();
    }
}