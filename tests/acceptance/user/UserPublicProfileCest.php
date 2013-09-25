<?php
use \WebGuy;

class UserPublicProfileCest
{
    public function testPublicUserProfile(WebGuy $I)
    {
        $user = 'yupe';
        $I->amOnPage(EditProfilePage::getPublicProfileUrl($user));
        $I->seeInCurrentUrl($user);
        $I->seeInTitle($user);
        $I->see('Мнений пока нет, станьте первым!');
    }
}