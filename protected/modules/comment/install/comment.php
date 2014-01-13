<?php
/**
 *
 * Файл конфигурации модуля
 *
 * @category YupeMigration
 * @package  yupe.modules.comment.install
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @link     http://yupe.ru
 **/
return array(
    'module'   => array(
        'class' => 'application.modules.comment.CommentModule',
    ),
    'import'    => array(      
        'application.modules.comment.models.*',
        'application.modules.blog.models.*',
        'vendor.yiiext.nested-set-behavior.NestedSetBehavior',
    ),
    'component' => array(),
    'rules'     => array(        
        '/comment/comment/captcha/refresh/<v>' => 'comment/comment/captcha/',
        '/comment/comment/captcha/<v>' => 'comment/comment/captcha/',
        '/comment/add/' => 'comment/comment/add/',
        '/comments/rss/<model>/<modelId>' => 'comment/commentRss/feed'
    ),
);