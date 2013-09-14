<?php
use \WebGuy;

class UserPublicProfileCest
{
    public function tryToTest(WebGuy $I) {
        $I->amOnPage('/user/people/userInfo/username/yupe');
        $I->seeInCurrentUrl('yupe');
        $I->seeInTitle('yupe');
        $I->see('Мнений пока нет, станьте первым!');
    }

}