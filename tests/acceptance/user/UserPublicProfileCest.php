<?php
use \WebGuy;

class UserPublicProfileCest
{
    public function testPubliUserProfile(WebGuy $I)
    {
        $I->amOnPage('/user/yupe');
        $I->seeInCurrentUrl('yupe');
        $I->seeInTitle('yupe');
        $I->see('Мнений пока нет, станьте первым!');
    }
}