<?php
namespace user;
use \WebGuy;

class UserEmailConfirmCest
{
    public function testEmailConfirm(WebGuy $I, $scenario)
    {
        $I = new WebGuy\UserSteps($scenario);
        $testMail = 'test2@testyupe.ru';
        $I->changeEmail($testMail);
        $key = $I->grabFromDatabase('yupe_user_user', 'activate_key', array('email' => $testMail));
        $I->amOnPage("/user/account/emailConfirm/key/$key");
        $I->see('Вы успешно подтвердили новый e-mail!','.alert-success');
        $I->seeInDatabase('yupe_user_user', array('email_confirm' => 1, 'email' => $testMail));
    }
}