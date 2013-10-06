<?php
namespace news;
use \WebGuy;

class NewsPublishCest
{
    public function tryToTestPagePublishing(WebGuy $I, $scenario)
    {
        $I = new WebGuy\UserSteps($scenario);
        $I->login('yupe@yupe.local','testpassword');
        $I->am('admin');
        $I->amGoingTo('test publishing news...');
        $I->amOnPage('/yupe/backend/index');
        $I->see('Панель управления "Юпи!"','h1');
        $I->amOnPage('/news/default/index');
        $I->see('Новости');
        $I->seeLink('Вторая не опубликованная новость');
        $I->click('Вторая не опубликованная новость');
        $I->see('Редактирование новости');
        $I->see('Вторая не опубликованная новость');
        $I->fillField('News[status]',1);
        $I->click('Сохранить новость и продолжить');
        $I->see('Новость обновлена!',\CommonPage::SUCCESS_CSS_CLASS);

        $I->logout();
        $I->am('anonymous user');
        $I->amGoingTo('test show just published news...');
        $I->amOnPage(\NewsPage::route('vtoraja-ne-opublikovannaja-novost'));
        $I->expectTo('see just published news...');
        $I->see('Вторая не опубликованная новость','h4');
        $I->see('Вторая не опубликованная новость текст');
        $I->seeInTitle('Вторая не опубликованная новость');
    }
}