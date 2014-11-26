<?php
namespace user;

use \WebGuy;

class UserEmailConfirmCest
{
    public function testEmailConfirm(WebGuy $I, $scenario)
    {
        $I = new WebGuy\UserSteps($scenario);
        $testMail = 'test2@yupe.local';
        $I->changeEmail($testMail);

        $key = $I->grabFromDatabase('yupe_user_tokens', 'token', ['user_id' => 1, 'type' => 3, 'status' => 0]);
        $I->amOnPage(\RecoveryPage::getConfirmRoute($key));
        $I->see('Вы успешно подтвердили новый e-mail!', \CommonPage::SUCCESS_CSS_CLASS);
        $I->seeInDatabase('yupe_user_user', ['email_confirm' => 1, 'email' => $testMail]);
        //check token
        $I->dontSeeInDatabase('yupe_user_tokens', ['user_id' => 1, 'type' => 3, 'status' => 0]);
    }
}
