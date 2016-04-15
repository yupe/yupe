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
return [
    'module' => [
        'class' => 'application.modules.comment.CommentModule',
        'panelWidgets' => [
            'application.modules.comment.widgets.PanelCommentStatWidget' => [
                'limit' => 5
            ]
        ],
        'visualEditors' => [
            'redactor' => [
                'class' => 'comment\widgets\editors\CommentRedactor',
            ],
            'textarea' => [
                'class' => 'yupe\widgets\editors\Textarea',
            ],
        ],
    ],
    'import' => [
        'application.modules.comment.models.*',
        'application.modules.comment.events.*',
        'application.modules.comment.listeners.*',
        'application.modules.blog.models.*',
        'vendor.yiiext.nested-set-behavior.NestedSetBehavior',
    ],
    'component' => [
        'commentManager' => [
            'class' => 'application.modules.comment.components.CommentManager',
        ],
        'eventManager' => [
            'class' => 'yupe\components\EventManager',
            'events' => [
                'comment.add.success' => [
                    ['NewCommentListener', 'onSuccessAddComment']
                ],
                'comment.before.add' => [
                    ['NewCommentListener', 'onBeforeAddComment']
                ],
                'comment.after.save' => [
                    ['NewCommentListener', 'onAfterSaveComment']
                ],
                'comment.after.delete' => [
                    ['NewCommentListener', 'onAfterDeleteComment']
                ]
            ]
        ]
    ],
    'commandMap' => [
        'comments-migrate-to-ns' => [
            'class' => 'application.modules.comment.commands.MigrateToNestedSets'
        ]
    ],
    'rules' => [
        '/comment/comment/captcha/refresh/<v>' => 'comment/comment/captcha/refresh/',
        '/comment/comment/captcha/<v>' => 'comment/comment/captcha/',
        '/comment/add/' => 'comment/comment/add/',
        '/comments/rss/<model>/<modelId>' => 'comment/commentRss/feed',
        '/comment/ajaxImageUpload' => 'comment/comment/ajaxImageUpload',
    ],
];
