<?php
use \WebGuy;

class UserListCest
{
    public function testUserList(WebGuy $I)
    {
        $I->amOnPage('/user/people/index');
        $I->see('Пользователи','h1');
        $I->seeLink('yupe');
    }
}