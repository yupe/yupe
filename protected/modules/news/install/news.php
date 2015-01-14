<?php
/**
 * Класс миграций для модуля News
 *
 * @category YupeMigration
 * @package  yupe.modules.news.install
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @link     http://yupe.ru
 **/
return [
    'module'    => [
        'class' => 'application.modules.news.NewsModule',
    ],
    'import'    => [],
    'component' => [],
    'rules'     => [
        '/news/'        => 'news/news/index',
        '/news/<alias>' => 'news/news/show',
    ],
];
