<?php
namespace tests\acceptance\blog;

use \WebGuy;
use tests\acceptance\pages\BlogPage;

class BlogCest
{
    public function tryToTestBlogs(WebGuy $I, $scenario)
    {
        $I->am('simple user');
        $I->amOnPage(BlogPage::BLOGS_URL);
        $I->seeInTitle('Блоги');
        $I->seeLink('Опубликованный блог');
        $I->see('Опубликованный блог описание');
        $I->dontSeeLink('Удаленный блог');

        $I->amGoingTo('test blog show page');
        $I->expectTo('see blog page');
        $I->amOnPage(BlogPage::getBlogRoute(BlogPage::PUBLIC_BLOG_SLUG));
        $I->seeLink('Опубликованный блог');
        $I->see('Опубликованный блог описание');
        $I->see('Участников нет =(');

        $I->seeLink('Первая публичная запись в опубликованном блоге');
        $tags = ['тег', 'тег2', 'тег3'];
        foreach ($tags as $tag) {
            $I->seeLink($tag);
        }

        $I->dontSeeLink('Черновик в опубликованном блоге');

        $I->amGoingTo('test blog page with deleted blog');
        $I->expectTo('see http exception');
        $I->amOnPage(BlogPage::getBlogRoute(BlogPage::DELETED_BLOG_SLUG));
        $I->see('Страница которую вы запросили не найдена.');
    }
}
