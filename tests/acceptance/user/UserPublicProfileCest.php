<?php
namespace tests\acceptance\user;

use \WebGuy;
use tests\acceptance\pages\EditProfilePage;

class UserPublicProfileCest
{
    public function testPublicUserProfile(WebGuy $I)
    {
        $user = 'yupe';
        $I->amOnPage(EditProfilePage::getPublicProfileUrl($user));
        $I->seeInCurrentUrl($user);
        $I->seeInTitle($user);
        $I->seeLink('yupe');
        $I->seeLink('Первая публичная запись в опубликованном блоге');
        $I->seeElement('div.avatar > img');
    }
}
