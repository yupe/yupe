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
return array(
    'module'    => array(
        'class' => 'application.modules.news.NewsModule',
    ),
    'import'    => array(),
    'component' => array(),
    'rules'     => array(
        '/news/'        => 'news/news/index',
        '/news/<alias>' => 'news/news/show',
    ),
);
