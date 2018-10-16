<?php
namespace tests\acceptance\comment;

use \WebGuy;
use tests\acceptance\pages\CommonPage;
use tests\acceptance\user\steps\UserSteps;

class CommentCest
{
    // tests
    public function tryToTestCommentsAntispam(WebGuy $I, $scenario)
    {
        $I = new UserSteps($scenario);

        $I->login(CommonPage::TEST_USER_NAME, CommonPage::TEST_PASSWORD);
        $I->am('admin');
        $I->amGoingTo('test comments antispam...');
        $I->amOnPage("/blogs/public-blog");
        $I->click('Первая публичная запись в опубликованном блоге');

        $I->see("Первая публичная запись в опубликованном блоге", "h4");
        $I->fillField('Comment[text]', "Antispam Test");
        $I->click("Добавить комментарий");
        $I->wait(1);
        $I->see("Спасибо, Ваша запись добавлена!", CommonPage::SUCCESS_CSS_CLASS);

        $I->fillField('Comment[text]', "Antispam Test");
        $I->click("Добавить комментарий");
        $I->wait(1);
        $I->see("Запись не добавлена!", CommonPage::ERROR_CSS_CLASS);

        $I->wait(15);

        $I->fillField('Comment[text]', "Antispam Test");
        $I->click("Добавить комментарий");
        $I->wait(1);
        $I->see("Спасибо, Ваша запись добавлена!", CommonPage::SUCCESS_CSS_CLASS);

    }

}
