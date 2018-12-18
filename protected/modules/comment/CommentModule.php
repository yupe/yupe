<?php

/**
 * CommentModule основной класс модуля comment
 *
 * @author    yupe team <team@yupe.ru>
 * @link      https://yupe.ru
 * @copyright 2009-2013 amyLabs && Yupe! team
 * @package   yupe.modules.comment
 * @version   0.6
 *
 */

use yupe\components\WebModule;

/**
 * Class CommentModule
 */
class CommentModule extends WebModule
{
    /**
     *
     */
    const VERSION = '1.1';

    /**
     * @var
     */
    public $defaultCommentStatus;
    /**
     * @var bool
     */
    public $autoApprove = true;
    /**
     * @var bool
     */
    public $notify = true;
    /**
     * @var
     */
    public $email;
    /**
     * @var int
     */
    public $showCaptcha = 1;
    /**
     * @var int
     */
    public $minCaptchaLength = 3;
    /**
     * @var int
     */
    public $maxCaptchaLength = 6;
    /**
     * @var int
     */
    public $rssCount = 10;
    /**
     * @var int
     */
    public $antiSpamInterval = 3;
    /**
     * @var string
     */
    public $allowedTags = 'p,br,strong,img[src|style],a[href]';
    /**
     * @var int
     */
    public $allowGuestComment = 0;
    /**
     * @var string
     */
    public $assetsPath = "application.modules.comment.views.assets";

    /**
     * @var
     */
    public $modelsAvailableForRss;

    /**
     * параметры для загрузки изображений
     */
    public $allowedExtensions = 'jpg,jpeg,png,gif';
    /**
     * @var int
     */
    public $minSize = 0;
    /**
     * @var int
     */
    public $maxSize = 5368709120;

    /**
     * @var string - id редактора
     */
    public $editor = 'textarea';

    /**
     * @return array
     */
    public function getDependencies()
    {
        return [
            'user',
            'image',
        ];
    }

    /**
     * @return array
     */
    public function getModelsAvailableForRss()
    {
        return empty($this->modelsAvailableForRss) ? [] : explode(',', $this->modelsAvailableForRss);
    }


    /**
     * @return array
     */
    public function getParamsLabels()
    {
        return [
            'defaultCommentStatus' => Yii::t('CommentModule.comment', 'Default comments status'),
            'autoApprove' => Yii::t('CommentModule.comment', 'Automatic comment confirmation'),
            'notify' => Yii::t('CommentModule.comment', 'Notify about comment?'),
            'email' => Yii::t('CommentModule.comment', 'Email for notifications'),
            'showCaptcha' => Yii::t('CommentModule.comment', 'Show captcha for guests'),
            'minCaptchaLength' => Yii::t('CommentModule.comment', 'Minimum captcha length'),
            'maxCaptchaLength' => Yii::t('CommentModule.comment', 'Maximum captcha length'),
            'rssCount' => Yii::t('CommentModule.comment', 'RSS records count'),
            'allowedTags' => Yii::t('CommentModule.comment', 'Accepted tags'),
            'antiSpamInterval' => Yii::t('CommentModule.comment', 'Antispam interval'),
            'allowGuestComment' => Yii::t('CommentModule.comment', 'Guest can comment ?'),
            'editor' => Yii::t('YupeModule.yupe', 'Visual editor'),
            'modelsAvailableForRss' => Yii::t(
                'CommentModule.comment',
                'Models available for rss export (for example: Post, Blog etc.)'
            ),
        ];
    }

    /**
     * @return array
     */
    public function getParamsDescriptions()
    {
        $allowedTagsDescription = CHtml::link(
            'http://htmlpurifier.org/live/configdoc/plain.html#HTML.Allowed',
            'http://htmlpurifier.org/live/configdoc/plain.html#HTML.Allowed',
            ['target' => '_blank']
        );

        return [
            'allowedTags' => $allowedTagsDescription,
        ];
    }

    /**
     * @return array
     */
    public function getEditableParams()
    {
        return [
            'allowGuestComment' => $this->getChoice(),
            'defaultCommentStatus' => Comment::model()->getStatusList(),
            'autoApprove' => $this->getChoice(),
            'notify' => $this->getChoice(),
            'email',
            'showCaptcha' => $this->getChoice(),
            'minCaptchaLength',
            'maxCaptchaLength',
            'rssCount',
            'allowedTags',
            'antiSpamInterval',
            'editor' => $this->getEditors(),
            'modelsAvailableForRss',
        ];
    }

    /**
     * @return array
     */
    public function getEditableParamsGroups()
    {
        return [
            'main' => [
                'label' => Yii::t('CommentModule.comment', 'Module general settings'),
                'items' => [
                    'defaultCommentStatus',
                    'autoApprove',
                    'notify',
                    'email',
                ],
            ],
            'captcha' => [
                'label' => Yii::t('CommentModule.comment', 'Captcha settings'),
                'items' => [
                    'showCaptcha',
                    'minCaptchaLength',
                    'maxCaptchaLength',
                ],
            ],
            'editor' => [
                'label' => Yii::t('YupeModule.yupe', 'Visual editors settings'),
                'items' => [
                    'editor',
                ],
            ],
            'rss' => [
                'label' => Yii::t('CommentModule.comment', 'RSS settings'),
                'items' => [
                    'modelsAvailableForRss',
                    'rssCount',
                ],
            ],
        ];
    }

    /**
     * @return string
     */
    public function getCategory()
    {
        return Yii::t('CommentModule.comment', 'Content');
    }

    /**
     * @return string
     */
    public function getName()
    {
        return Yii::t('CommentModule.comment', 'Comments');
    }

    /**
     * @return array|bool
     */
    public function checkSelf()
    {
        $count = Comment::model()->new()->count();

        $messages = [];

        if ($count) {
            $messages[WebModule::CHECK_NOTICE][] = [
                'type' => WebModule::CHECK_NOTICE,
                'message' => Yii::t(
                    'CommentModule.comment',
                    'You have {{count}} new comments. {{link}}',
                    [
                        '{{count}}' => $count,
                        '{{link}}' => CHtml::link(
                            Yii::t('CommentModule.comment', 'Comments moderation'),
                            [
                                '/comment/commentBackend/index',
                                'Comment[status]' => Comment::STATUS_NEED_CHECK,
                            ]
                        ),
                    ]
                ),
            ];
        }

        return isset($messages[WebModule::CHECK_NOTICE]) ? $messages : true;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return Yii::t('CommentModule.comment', 'Module for simple comments support');
    }

    /**
     * @return string
     */
    public function getVersion()
    {
        return Yii::t('CommentModule.comment', self::VERSION);
    }

    /**
     * @return string
     */
    public function getAuthor()
    {
        return Yii::t('CommentModule.comment', 'yupe team');
    }

    /**
     * @return string
     */
    public function getAuthorEmail()
    {
        return Yii::t('CommentModule.comment', 'team@yupe.ru');
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return Yii::t('CommentModule.comment', 'https://yupe.ru');
    }

    /**
     * @return string
     */
    public function getIcon()
    {
        return "fa fa-fw fa-comment";
    }

    /**
     * @return array
     */
    public function getNavigation()
    {
        return [
            [
                'icon' => 'fa fa-fw fa-list-alt',
                'label' => Yii::t('CommentModule.comment', 'Comments list'),
                'url' => ['/comment/commentBackend/index'],
            ],
            [
                'icon' => 'fa fa-fw fa-plus-square',
                'label' => Yii::t('CommentModule.comment', 'Create comment'),
                'url' => ['/comment/commentBackend/create'],
            ],
        ];
    }

    /**
     * @return string
     */
    public function getAdminPageLink()
    {
        return '/comment/commentBackend/index';
    }

    /**
     *
     */
    public function init()
    {
        parent::init();

        $import = ['application.modules.comment.models.*'];

        foreach (Yii::app()->getModules() as $module => $data) {
            $import[] = "application.modules.{$module}.models.*";
            $import[] = "application.modules.{$module}.listeners.*";
        }

        $this->setImport($import);

        if (!$this->email) {
            $this->email = Yii::app()->getModule('yupe')->email;
        }

        $this->defaultCommentStatus = Comment::STATUS_NEED_CHECK;
    }

    /**
     * @return array
     */
    public function getAuthItems()
    {
        return [
            [
                'name' => 'Comment.CommentManager',
                'description' => Yii::t('CommentModule.comment', 'Manage comments'),
                'type' => AuthItem::TYPE_TASK,
                'items' => [
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'Comment.CommentBackend.Create',
                        'description' => Yii::t('CommentModule.comment', 'Creating comment'),
                    ],
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'Comment.CommentBackend.Delete',
                        'description' => Yii::t('CommentModule.comment', 'Removing comment'),
                    ],
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'Comment.CommentBackend.Index',
                        'description' => Yii::t('CommentModule.comment', 'List of comments'),
                    ],
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'Comment.CommentBackend.Update',
                        'description' => Yii::t('CommentModule.comment', 'Editing comment'),
                    ],
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'Comment.CommentBackend.View',
                        'description' => Yii::t('CommentModule.comment', 'Viewing comments'),
                    ],
                ],
            ],
        ];
    }
}
