<?php
namespace tests\acceptance\feedback;

use \WebGuy;
use tests\acceptance\pages\CommonPage;
use tests\acceptance\pages\FeedBackPage;
use tests\acceptance\user\steps\UserSteps;

class FeedBackCest
{
    public function tryToTestContactsPage(WebGuy $I, $scenario)
    {
        $I->am('simple user');
        $I->amGoingTo('test contacts page');
        $I->amOnPage(FeedBackPage::CONTACTS_URL);
        $I->seeInTitle('Контакты');
        $I->see('Контакты', 'h1');
        $I->seeInField(FeedBackPage::$nameField, '');
        $I->seeInField(FeedBackPage::$emailField, '');
        $I->seeInField(FeedBackPage::$themeField, '');
        $I->seeInField(FeedBackPage::$textField, '');
        $I->see(FeedBackPage::$buttonLabel);

        $I->amGoingTo('test email validation');
        $I->fillField(FeedBackPage::$nameField, 'test_name');
        $I->fillField(FeedBackPage::$emailField, 'test_email');
        $I->fillField(FeedBackPage::$themeField, 'test_theme');
        $I->fillField(FeedBackPage::$textField, 'test_text');
        $I->click(FeedBackPage::$buttonLabel);
        $I->see('Email не является правильным E-Mail адресом.', CommonPage::ERROR_CSS_CLASS);

        $I->amGoingTo('test save feedback');
        $I->fillField(FeedBackPage::$emailField, 'test@yupe.ru');
        $I->click(FeedBackPage::$buttonLabel);
        $I->see('Ваше сообщение отправлено! Спасибо!', CommonPage::SUCCESS_CSS_CLASS);
        $I->seeInDatabase(
            'yupe_feedback_feedback',
            [
                'name'   => 'test_name',
                'email'  => 'test@yupe.ru',
                'theme'  => 'test_theme',
                'text'   => 'test_text',
                'is_faq' => 0,
                'status' => 0
            ]
        );

        $I->amGoingTo('check that new message is hide from public access');
        $I->amOnPage(FeedBackPage::routeFaq(1));
        $I->see('Страница которую вы запросили не найдена.');

        $I->amOnPage(FeedBackPage::FAQ_URL);
        $I->see('Вопросы и ответы', 'h1');
        $I->see('Задайте вопрос ?!', '.btn');
        $I->dontSeeLink('test_theme');

        $I->amGoingTo('mark feedback message as faq');
        $I = new UserSteps($scenario);
        $I->loginAsAdminAndGoToThePanel(CommonPage::TEST_USER_NAME, CommonPage::TEST_PASSWORD);

        $I->amOnPage('/backend/feedback/feedback');
        $I->see('test_name');
        $I->amOnPage('/backend/feedback/feedback/update/1');
        $I->selectOption('FeedBack[status]', 'Ответ отправлен');
        $I->dontSeeCheckboxIsChecked('#FeedBack_is_faq');
        $I->checkOption('#FeedBack_is_faq');
        $I->executeJs('$("textarea[name^=FeedBack]").show();');
        $I->fillField('FeedBack[answer]', 'test_answer');
        $I->click('Сохранить сообщение и закрыть');
        $I->see('Сообщение обновлено!', CommonPage::SUCCESS_CSS_CLASS);
        $I->seeInCurrentUrl('/backend/feedback/feedback');
        $I->seeInDatabase(
            'yupe_feedback_feedback',
            [
                'name'   => 'test_name',
                'email'  => 'test@yupe.ru',
                'theme'  => 'test_theme',
                'answer' => 'test_answer',
                'is_faq' => 1,
                'status' => 3
            ]
        );

        $I->logout();

        $I->amGoingTo('test view feedback message on the public site');
        $I->amOnPage(FeedBackPage::FAQ_URL);
        $I->see('Вопросы и ответы', 'h1');
        $I->see('Задайте вопрос ?!', '.btn');
        $I->seeLink('test_theme');
        $I->click('test_theme');
        $I->seeLink('Подробнее...', FeedBackPage::routeFaq(1));
        $I->click('Подробнее...');

        $I->see('test_theme #1', 'h1');
        $I->see('Задайте вопрос ?!', '.btn');

        $check = ['test_name', 'test_theme', 'test_text', 'test_answer', 'yupe'];

        foreach ($check as $ch) {
            $I->see($ch);
        }

    }
}
