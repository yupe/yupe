<?php

/**
 * CommentModule основной класс модуля comment
 *
 * @author    yupe team <team@yupe.ru>
 * @link      http://yupe.ru
 * @copyright 2009-2013 amyLabs && Yupe! team
 * @package   yupe.modules.comment
 * @version   0.6
 *
 */

use yupe\components\WebModule;

class CommentModule extends WebModule
{
    const VERSION = '0.9';

    public $defaultCommentStatus;
    public $autoApprove = true;
    public $notify = true;
    public $email;
    public $showCaptcha = 1;
    public $minCaptchaLength = 3;
    public $maxCaptchaLength = 6;
    public $rssCount = 10;
    public $antiSpamInterval = 3;
    public $allowedTags;
    public $allowGuestComment = 0;

    public function getDependencies()
    {
        return array(
            'user',
        );
    }

    public function getParamsLabels()
    {
        return array(
            'defaultCommentStatus' => Yii::t('CommentModule.comment', 'Default comments status'),
            'autoApprove'          => Yii::t('CommentModule.comment', 'Automatic comment confirmation'),
            'notify'               => Yii::t('CommentModule.comment', 'Notify about comment?'),
            'email'                => Yii::t('CommentModule.comment', 'Email for notifications'),
            'adminMenuOrder'       => Yii::t('CommentModule.comment', 'Menu items order'),
            'showCaptcha'          => Yii::t('CommentModule.comment', 'Show captcha for guests'),
            'minCaptchaLength'     => Yii::t('CommentModule.comment', 'Minimum captcha length'),
            'maxCaptchaLength'     => Yii::t('CommentModule.comment', 'Maximum captcha length'),
            'rssCount'             => Yii::t('CommentModule.comment', 'RSS records count'),
            'allowedTags'          => Yii::t('CommentModule.comment', 'Accepted tags'),
            'antiSpamInterval'     => Yii::t('CommentModule.comment', 'Antispam interval'),
            'allowGuestComment'    => Yii::t('CommentModule.comment', 'Guest can comment ?')
        );
    }

    public function getEditableParams()
    {
        return array(
            'allowGuestComment'    => $this->getChoice(),
            'defaultCommentStatus' => Comment::model()->getStatusList(),
            'autoApprove'          => $this->getChoice(),
            'notify'               => $this->getChoice(),
            'email',
            'adminMenuOrder',
            'showCaptcha'          => $this->getChoice(),
            'minCaptchaLength',
            'maxCaptchaLength',
            'rssCount',
            'allowedTags',
            'antiSpamInterval'
        );
    }

    public function getEditableParamsGroups()
    {
        return array(
            'main'    => array(
                'label' => Yii::t('CommentModule.comment', 'Module general settings'),
                'items' => array(
                    'defaultCommentStatus',
                    'autoApprove',
                    'notify',
                    'email',
                    'adminMenuOrder',
                )
            ),
            'captcha' => array(
                'label' => Yii::t('CommentModule.comment', 'Captcha settings'),
                'items' => array(
                    'showCaptcha',
                    'minCaptchaLength',
                    'maxCaptchaLength'
                )
            ),
        );
    }

    public function getCategory()
    {
        return Yii::t('CommentModule.comment', 'Content');
    }

    public function getName()
    {
        return Yii::t('CommentModule.comment', 'Comments');
    }

    public function checkSelf()
    {
        $count = Comment::model()->new()->count();

        $messages = array();

        if ($count) {
            $messages[WebModule::CHECK_NOTICE][] = array(
                'type'    => WebModule::CHECK_NOTICE,
                'message' => Yii::t(
                    'CommentModule.comment',
                    'You have {{count}} new comments. {{link}}',
                    array(
                        '{{count}}' => $count,
                        '{{link}}'  => CHtml::link(
                            Yii::t('CommentModule.comment', 'Comments moderation'),
                            array(
                                '/comment/commentBackend/index',
                                'Comment[status]' => Comment::STATUS_NEED_CHECK,
                            )
                        ),
                    )
                ),
            );
        }

        return isset($messages[WebModule::CHECK_NOTICE]) ? $messages : true;
    }

    public function getDescription()
    {
        return Yii::t('CommentModule.comment', 'Module for simple comments support');
    }

    public function getVersion()
    {
        return Yii::t('CommentModule.comment', self::VERSION);
    }

    public function getAuthor()
    {
        return Yii::t('CommentModule.comment', 'yupe team');
    }

    public function getAuthorEmail()
    {
        return Yii::t('CommentModule.comment', 'team@yupe.ru');
    }

    public function getUrl()
    {
        return Yii::t('CommentModule.comment', 'http://yupe.ru');
    }

    public function getIcon()
    {
        return "fa fa-fw fa-comment";
    }

    public function getNavigation()
    {
        return array(
            array(
                'icon'  => 'fa fa-fw fa-list-alt',
                'label' => Yii::t('CommentModule.comment', 'Comments list'),
                'url'   => array('/comment/commentBackend/index')
            ),
            array(
                'icon'  => 'fa fa-fw fa-plus-square',
                'label' => Yii::t('CommentModule.comment', 'Create comment'),
                'url'   => array('/comment/commentBackend/create')
            ),
        );
    }

    public function getAdminPageLink()
    {
        return '/comment/commentBackend/index';
    }

    public function init()
    {
        parent::init();

        $import = array('application.modules.comment.models.*');

        foreach (Yii::app()->getModules() as $module => $data) {
            $import[] = "application.modules.{$module}.models.*";
        }

        $this->setImport($import);

        if (!$this->email) {
            $this->email = Yii::app()->getModule('yupe')->email;
        }

        $this->defaultCommentStatus = Comment::STATUS_NEED_CHECK;
    }

    public function getAuthItems()
    {
        return array(
            array(
                'name'        => 'Comment.CommentManager',
                'description' => Yii::t('CommentModule.comment', 'Manage comments'),
                'type'        => AuthItem::TYPE_TASK,
                'items'       => array(
                    array(
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'Comment.CommentBackend.Create',
                        'description' => Yii::t('CommentModule.comment', 'Creating comment')
                    ),
                    array(
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'Comment.CommentBackend.Delete',
                        'description' => Yii::t('CommentModule.comment', 'Removing comment')
                    ),
                    array(
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'Comment.CommentBackend.Index',
                        'description' => Yii::t('CommentModule.comment', 'List of comments')
                    ),
                    array(
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'Comment.CommentBackend.Update',
                        'description' => Yii::t('CommentModule.comment', 'Editing comments')
                    ),
                    array(
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'Comment.CommentBackend.Inline',
                        'description' => Yii::t('CommentModule.comment', 'Editing comments')
                    ),
                    array(
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'Comment.CommentBackend.View',
                        'description' => Yii::t('CommentModule.comment', 'Viewing comments')
                    ),
                )
            )
        );
    }
}
