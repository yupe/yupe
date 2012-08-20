<?php

return array(
    'menu' => array(
        'class' => 'application.modules.menu.MenuModule',
    ),
    'queue' => array(
        'class' => 'application.modules.queue.QueueModule',
    ),
    'catalog' => array(
        'class' => 'application.modules.catalog.CatalogModule',
    ),
    'mail' => array(
        'class' => 'application.modules.mail.MailModule',
    ),
    'blog' => array(
        'class' => 'application.modules.blog.BlogModule',
    ),
    'social' => array(
        'class' => 'application.modules.social.SocialModule',
    ),
    'comment' => array(
        'class' => 'application.modules.comment.CommentModule',
    ),
    'dictionary' => array(
        'class' => 'application.modules.dictionary.DictionaryModule',
    ),

    'gallery' => array(
        'class' => 'application.modules.gallery.GalleryModule',
    ),
    /*
    'vote' => array(
        'class' => 'application.modules.vote.VoteModule',
    ),
    'contest' => array(
        'class' => 'application.modules.contest.ContestModule',
    ),
    */
    'image' => array(
        'class' => 'application.modules.image.ImageModule',
    ),
    'yupe' => array(
        'class' => 'application.modules.yupe.YupeModule',
        'brandUrl' => 'http://yupe.ru?from=engine',
    ),
    'install' => array(
        'class' => 'application.modules.install.InstallModule',
    ),
    'category' => array(
        'class' => 'application.modules.category.CategoryModule',
    ),
    'news' => array(
        'class' => 'application.modules.news.NewsModule',
    ),
    'user' => array(
        'class' => 'application.modules.user.UserModule',
        'documentRoot' => $_SERVER['DOCUMENT_ROOT'],
        'avatarsDir' => '/yupe/avatars',
        'avatarExtensions' => array('jpg', 'png', 'gif'),
        'notifyEmailFrom' => 'test@test.ru',
        'urlRules' => array(
            'user/people/<username:\w+>/<mode:(topics|comments)>' => 'user/people/userInfo',
            'user/people/<username:\w+>' => 'user/people/userInfo',
            'user/people/' => 'user/people/index',
        ),
    ),
    'page' => array(
        'class' => 'application.modules.page.PageModule',
        'layout' => 'application.views.layouts.column2',
    ),
    'contentblock' => array(
        'class' => 'application.modules.contentblock.ContentBlockModule',
    ),
    'feedback' => array(
        'class' => 'application.modules.feedback.FeedbackModule',
        'notifyEmailFrom' => 'test@test.ru',
        'emails' => 'test_1@test.ru, test_2@test.ru',
    ),
    'yeeki' => array(
        'class' => 'application.modules.yeeki.YeekiModule',
        'modules' => array(
            'wiki' => array(
                'userAdapter' => array('class' => 'WikiUser'),
            ),
        ),
    ),
    // подключение gii в режиме боевой работы рекомендуется отключить (подробнее http://www.yiiframework.com/doc/guide/1.1/en/quickstart.first-app)
    'gii' => array(
        'class' => 'system.gii.GiiModule',
        'password' => 'giiYupe',
        'generatorPaths' => array(
            'application.modules.yupe.extensions.yupe.gii',
        ),
        'ipFilters' => array(),
        /*
        'generatorPaths'=>array(
            'bootstrap.gii',
        ),
        */
    ),
);
?>