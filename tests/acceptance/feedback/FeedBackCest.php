<?php
namespace feedback;
use \WebGuy;

class FeedBackCest
{
    public function tryToTestContactsPage(WebGuy $I)
    {
        $I->am('simple user');
        $I->amGoingTo('test contacts page');
        $I->amOnPage(\FeedBackPage::CONTACTS_URL);
        $I->seeInTitle('Контакты');
        $I->see('Контакты','h1');
        $I->seeInField(\FeedBackPage::$nameField,'');
        $I->seeInField(\FeedBackPage::$emailField,'');
        $I->seeInField(\FeedBackPage::$themeField,'');
        $I->seeInField(\FeedBackPage::$textField,'');
        $I->see(\FeedBackPage::$buttonLabel);

        $I->amGoingTo('test email validation');
        $I->fillField(\FeedBackPage::$nameField,'test_name');
        $I->fillField(\FeedBackPage::$emailField,'test_email');
        $I->fillField(\FeedBackPage::$themeField,'test_theme');
        $I->fillField(\FeedBackPage::$textField,'test_text');
        $I->click(\FeedBackPage::$buttonLabel);
        $I->see('Email не является правильным E-Mail адресом.',\CommonPage::ERROR_CSS_CLASS);

    }
}