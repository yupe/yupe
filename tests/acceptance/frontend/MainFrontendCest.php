<?php

namespace tests\acceptance\frontend;

use \WebGuy;
use tests\acceptance\pages\BlogPage;
use tests\acceptance\pages\NewsPage;
use tests\acceptance\pages\GalleryPage;
use tests\acceptance\pages\FeedBackPage;

class MainFrontendCest
{
    public function tryToTestFrontend(WebGuy $I, $scenario)
    {
        $I->amGoingTo('test main modules on frontend');
        $I->amOnPage('/ru/');
        $I->see('Первая публичная запись в опубликованном блоге');

        //blogs
        $I->amOnPage(BlogPage::BLOGS_URL);
        $I->seeInTitle('Блоги');
        $I->seeLink('Опубликованный блог');
        $I->see('Опубликованный блог описание');
        $I->amGoingTo('test blog show page');
        $I->expectTo('see blog page');
        $I->amOnPage(BlogPage::getBlogRoute(BlogPage::PUBLIC_BLOG_SLUG));
        $I->seeLink('Опубликованный блог');
        $I->see('Опубликованный блог описание');
        $I->see('Участников нет =(');

        //feedback
        $I->amGoingTo('test contacts page');
        $I->amOnPage(FeedBackPage::CONTACTS_URL);
        $I->seeInTitle('Контакты');
        $I->see('Контакты', 'h1');
        $I->amOnPage(FeedBackPage::FAQ_URL);
        $I->see('Вопросы и ответы', 'h1');
        $I->see('Задайте вопрос ?!', '.btn');

        //news
        $I->am('simple user');
        $I->amGoingTo('test news list page...');
        $I->amOnPage(NewsPage::URL);
        $I->see('Новости', 'h1');
        $I->seeLink('Первая опубликованная новость');
        $I->am('anonymous user');
        $I->amGoingTo('test show news page...');
        $I->amOnPage(NewsPage::route('pervaja-opublikovannaja-novost'));
        $I->expectTo('see published news...');
        $I->see('Первая опубликованная новость', 'h4');
        $I->see('Первая опубликованная текст');
        $I->seeInTitle('Первая опубликованная новость');

        //page
        $I->wantToTest('show published page...');
        $I->amOnPage('/pages/opublikovannaja-starnica');
        $I->seeInTitle('Опубликованная страница');
        $I->see('Опубликованная страница', 'h1');
        $I->see('Опубликованная страница текст');

        //users
        $I->amOnPage('/users/');
        $I->see('Пользователи', 'h1');
        $I->seeLink('yupe');

        //gallery
        $I->amOnPage(GalleryPage::ALBUMS_URL);
        $I->see('Галереи изображений');
        $I->seeLink('Первая галерея');

        $I->amOnPage('/en/');
        $I->see('Discuss', 'h3');
        $I->see('Latest posts', 'h3');
        $I->see('Blogs', 'h3');
        $I->see('Tags cloud', 'h3');

        $I->amOnPage('/ru/');
        $I->see('Обсуждают', 'h3');
        $I->see('Последние записи', 'h3');
        $I->see('Блоги', 'h3');
        $I->see('Теги', 'h3');
    }
}
