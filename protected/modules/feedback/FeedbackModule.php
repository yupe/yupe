<?php

/**
 * FeedbackModule основной класс модуля feedback
 *
 * @author yupe team <team@yupe.ru>
 * @link http://yupe.ru
 * @copyright 2009-2013 amyLabs && Yupe! team
 * @package yupe.modules.feedback
 * @since 0.1
 *
 */

use yupe\components\WebModule;

class FeedbackModule extends WebModule
{
    const VERSION = '0.9';

    public $backEnd = array('DbFeedbackSender', 'EmailFeedbackSender');
    public $emails;
    public $types;
    public $showCaptcha = 0;
    public $notifyEmailFrom;
    public $sendConfirmation = 0;
    public $successPage;
    public $cacheTime = 60;
    public $minCaptchaLength = 3;
    public $maxCaptchaLength = 6;

    const BACKEND_EMAIL = 'EmailFeedbackSender';
    const BACKEND_DB = 'DbFeedbackSender';

    public static $logCategory = 'application.modules.feedback';

    public function getDependencies()
    {
        return array(
            'category',
            'user',
            'mail'
        );
    }

    public function getParamsLabels()
    {
        return array(
            'showCaptcha'      => Yii::t('FeedbackModule.feedback', 'Show captcha'),
            'emails'           => Yii::t('FeedbackModule.feedback', 'Message receivers (email, separated by comma)'),
            'notifyEmailFrom'  => Yii::t('FeedbackModule.feedback', 'Email message will be send from'),
            'adminMenuOrder'   => Yii::t('FeedbackModule.feedback', 'Menu item order'),
            'sendConfirmation' => Yii::t('FeedbackModule.feedback', 'Send notification'),
            'successPage'      => Yii::t('FeedbackModule.feedback', 'Page after form was sent'),
            'cacheTime'        => Yii::t('FeedbackModule.feedback', 'Counter caching time (seconds)'),
            'mainCategory'     => Yii::t('FeedbackModule.feedback', 'Main messages category'),
            'minCaptchaLength' => Yii::t('FeedbackModule.feedback', 'Minimum captcha length'),
            'maxCaptchaLength' => Yii::t('FeedbackModule.feedback', 'Maximum captcha length'),
        );
    }

    public function getEditableParams()
    {
        return array(
            'showCaptcha'      => $this->getChoice(),
            'sendConfirmation' => $this->getChoice(),
            'notifyEmailFrom',
            'emails',
            'adminMenuOrder',
            'successPage',
            'cacheTime',
            'mainCategory'     => CHtml::listData($this->getCategoryList(), 'id', 'name'),
            'minCaptchaLength',
            'maxCaptchaLength'
        );
    }

    public function getEditableParamsGroups()
    {
        return array(
            'main'    => array(
                'label' => Yii::t('FeedbackModule.feedback', 'General module settings'),
                'items' => array(
                    'sendConfirmation',
                    'notifyEmailFrom',
                    'emails',
                    'adminMenuOrder',
                    'successPage',
                    'cacheTime',
                    'mainCategory'
                )
            ),
            'captcha' => array(
                'label' => Yii::t('FeedbackModule.feedback', 'Captcha settings'),
                'items' => array(
                    'showCaptcha',
                    'minCaptchaLength',
                    'maxCaptchaLength'
                )
            ),
        );
    }

    public function checkSelf()
    {
        $messages = array();

        if (in_array(FeedbackModule::BACKEND_EMAIL, $this->backEnd) && (!$this->emails || !count(
                    explode(',', $this->emails)
                ))
        ) {
            $messages[WebModule::CHECK_ERROR][] = array(
                'type'    => WebModule::CHECK_ERROR,
                'message' => Yii::t(
                        'FeedbackModule.feedback',
                        'Select feedback message email receivers (emails) {link}',
                        array(
                            '{link}' => CHtml::link(
                                    Yii::t('FeedbackModule.feedback', 'Change module settings'),
                                    array(
                                        '/yupe/backend/modulesettings/',
                                        'module' => $this->id,
                                    )
                                ),
                        )
                    ),
            );
        }

        if (!$this->notifyEmailFrom) {
            $messages[WebModule::CHECK_ERROR][] = array(
                'type'    => WebModule::CHECK_ERROR,
                'message' => Yii::t(
                        'FeedbackModule.feedback',
                        'Select email which will be display in "From" field {link}',
                        array(
                            '{link}' => CHtml::link(
                                    Yii::t('FeedbackModule.feedback', 'Change module settings'),
                                    array(
                                        '/yupe/backend/modulesettings/',
                                        'module' => $this->id,
                                    )
                                ),
                        )
                    ),
            );
        }

        $count = FeedBack::model()->new()->cache($this->cacheTime)->count();

        if ($count) {
            $messages[WebModule::CHECK_NOTICE][] = array(
                'type'    => WebModule::CHECK_NOTICE,
                'message' => Yii::t(
                        'FeedbackModule.feedback',
                        'You have {{count}} ',
                        array(
                            '{{count}}' => $count
                        )
                    ) . Yii::t(
                        'FeedbackModule.feedback',
                        'new message |new messages |new messages ',
                        $count
                    ) . ' ' . CHtml::link(
                        Yii::t('FeedbackModule.feedback', 'Show and reply?'),
                        array(
                            '/feedback/feedbackBackend/index/',
                            'order'          => 'status.asc',
                            'FeedbBack_sort' => 'status'
                        )
                    )
            );
        }

        return (isset($messages[WebModule::CHECK_ERROR]) || isset($messages[WebModule::CHECK_NOTICE])) ? $messages : true;
    }

    public function getAdminPageLink()
    {
        return '/feedback/feedbackBackend/index';
    }

    public function getNavigation()
    {
        return array(
            array(
                'icon'  => 'fa fa-fw fa-list-alt',
                'label' => Yii::t('FeedbackModule.feedback', 'Messages list'),
                'url'   => array('/feedback/feedbackBackend/index')
            ),
            array(
                'icon'  => 'fa fa-fw fa-plus-square',
                'label' => Yii::t('FeedbackModule.feedback', 'Create message'),
                'url'   => array('/feedback/feedbackBackend/create')
            ),
            array(
                'icon'  => 'fa fa-fw fa-folder-open',
                'label' => Yii::t('FeedbackModule.feedback', 'Messages categories'),
                'url'   => array('/category/categoryBackend/index', 'Category[parent_id]' => (int)$this->mainCategory)
            ),
        );
    }

    public function getName()
    {
        return Yii::t('FeedbackModule.feedback', 'Feedback');
    }

    public function getCategory()
    {
        return Yii::t('FeedbackModule.feedback', 'Services');
    }

    public function getDescription()
    {
        return Yii::t('FeedbackModule.feedback', 'Module for feedback management');
    }

    public function getVersion()
    {
        return self::VERSION;
    }

    public function getAuthor()
    {
        return Yii::t('FeedbackModule.feedback', 'yupe team');
    }

    public function getAuthorEmail()
    {
        return Yii::t('FeedbackModule.feedback', 'team@yupe.ru');
    }

    public function getUrl()
    {
        return Yii::t('FeedbackModule.feedback', 'http://yupe.ru');
    }

    public function getIcon()
    {
        return 'fa fa-fw fa-retweet';
    }

    /**
     * Возвращаем статус, устанавливать ли галку для установки модуля в инсталяторе по умолчанию:
     *
     * @return bool
     **/
    public function getIsInstallDefault()
    {
        return true;
    }

    public function init()
    {
        parent::init();

        $this->setImport(
            array(
                'feedback.models.*',
                'feedback.components.*'
            )
        );

        if (!$this->emails) {
            $this->emails = Yii::app()->getModule('yupe')->email;
        }
    }

    public function getTypes()
    {
        return is_array($this->types) ? $this->types : array();
    }

    public function getAuthItems()
    {
        return array(
            array(
                'name'        => 'Feedback.FeedbackManager',
                'description' => Yii::t('FeedbackModule.feedback', 'Manage feedback'),
                'type'        => AuthItem::TYPE_TASK,
                'items'       => array(
                    array(
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'Feedback.FeedbackBackend.Create',
                        'description' => Yii::t('FeedbackModule.feedback', 'Creating feedback')
                    ),
                    array(
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'Feedback.FeedbackBackend.Delete',
                        'description' => Yii::t('FeedbackModule.feedback', 'Removing feedback')
                    ),
                    array(
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'Feedback.FeedbackBackend.Index',
                        'description' => Yii::t('FeedbackModule.feedback', 'List of feedback')
                    ),
                    array(
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'Feedback.FeedbackBackend.Update',
                        'description' => Yii::t('FeedbackModule.feedback', 'Editing feedback')
                    ),
                    array(
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'Feedback.FeedbackBackend.Inline',
                        'description' => Yii::t('FeedbackModule.feedback', 'Editing feedback')
                    ),
                    array(
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'Feedback.FeedbackBackend.View',
                        'description' => Yii::t('FeedbackModule.feedback', 'Viewing feedback')
                    ),
                    array(
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'Feedback.FeedbackBackend.Answer',
                        'description' => Yii::t('FeedbackModule.feedback', 'Answer feedback')
                    ),
                )
            )
        );
    }

}
