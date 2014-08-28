<?php
namespace comment;

use \WebGuy;

class CommentCest
{
    // tests
    public function tryToTestCommentsAntispam(WebGuy $I, $scenario)
    {
        $I = new WebGuy\UserSteps($scenario);

        $I->login(\CommonPage::TEST_USER_NAME, \CommonPage::TEST_PASSWORD);
        $I->am('admin');
        $I->amGoingTo('test comments antispam...');
        $I->amOnPage("/blogs/public-blog");
        $I->click('Первая публичная запись в опубликованном блоге');

        $I->see("Первая публичная запись в опубликованном блоге", "h4");
        $I->fillField('Comment[text]', "Antispam Test");
        $I->click("Добавить комментарий");
        $I->wait(3000);
        $I->see("Спасибо, Ваша запись добавлена!", \CommonPage::SUCCESS_CSS_CLASS);

        $I->fillField('Comment[text]', "Antispam Test");
        $I->click("Добавить комментарий");
        $I->wait(3000);
        $I->see("Защита от спама", \CommonPage::ERROR_CSS_CLASS);

        $I->wait(15000);

        $I->fillField('Comment[text]', "Antispam Test");
        $I->click("Добавить комментарий");
        $I->wait(1000);
        $I->see("Спасибо, Ваша запись добавлена!", \CommonPage::SUCCESS_CSS_CLASS);

    }

}
