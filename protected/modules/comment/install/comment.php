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
    'module'    => array(
        'class'        => 'application.modules.comment.CommentModule',
        'panelWidgets' => array(
            'application.modules.comment.widgets.PanelCommentStatWidget' => array(
                'limit' => 5
            )
        ),
    ),
    'import'    => array(
        'application.modules.comment.models.*',
        'application.modules.comment.events.*',
        'application.modules.comment.listeners.*',
        'application.modules.blog.models.*',
        'vendor.yiiext.nested-set-behavior.NestedSetBehavior',
    ),
    'component' => array(
        'commentManager' => array(
            'class' => 'application.modules.comment.components.CommentManager',
        ),
        'eventManager'   => array(
            'class'  => 'yupe\components\EventManager',
            'events' => array(
                'comment.add.success' => array(
                    array('NewCommentListener', 'onSuccessAddComment')
                ),
                'comment.before.add' => array(
                    array('NewCommentListener', 'onBeforeAddComment')
                ),
                'comment.after.save' => array(
                    array('NewCommentListener', 'onAfterSaveComment')
                )
            )
        )
    ),
    'rules'     => array(
        '/comment/comment/captcha/refresh/<v>' => 'comment/comment/captcha/refresh/',
        '/comment/comment/captcha/<v>'         => 'comment/comment/captcha/',
        '/comment/add/'                        => 'comment/comment/add/',
        '/comments/rss/<model>/<modelId>'      => 'comment/commentRss/feed'
    ),
);
