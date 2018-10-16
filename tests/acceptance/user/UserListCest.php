<?php
namespace tests\acceptance\user;

use \WebGuy;

class UserListCest
{
    public function testUserList(WebGuy $I)
    {
        $I->amOnPage('/users/');
        $I->see('Пользователи', 'h1');
        $I->seeLink('yupe');
    }
}
