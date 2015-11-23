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

/**
 * Class FeedbackModule
 */
class FeedbackModule extends WebModule
{
    /**
     *
     */
    const VERSION = '0.9.9';

    /**
     * @var array
     */
    public $backEnd = ['DbFeedbackSender', 'EmailFeedbackSender'];
    /**
     * @var
     */
    public $emails;
    /**
     * @var
     */
    public $types;
    /**
     * @var int
     */
    public $showCaptcha = 0;
    /**
     * @var
     */
    public $notifyEmailFrom;
    /**
     * @var int
     */
    public $sendConfirmation = 0;
    /**
     * @var
     */
    public $successPage;
    /**
     * @var int
     */
    public $cacheTime = 60;
    /**
     * @var int
     */
    public $minCaptchaLength = 3;
    /**
     * @var int
     */
    public $maxCaptchaLength = 6;

    /**
     *
     */
    const BACKEND_EMAIL = 'EmailFeedbackSender';
    /**
     *
     */
    const BACKEND_DB = 'DbFeedbackSender';

    /**
     * @var string
     */
    public static $logCategory = 'application.modules.feedback';

    /**
     * @return array
     */
    public function getDependencies()
    {
        return [
            'category',
            'user',
            'mail',
        ];
    }

    /**
     * @return array
     */
    public function getParamsLabels()
    {
        return [
            'showCaptcha' => Yii::t('FeedbackModule.feedback', 'Show captcha'),
            'emails' => Yii::t('FeedbackModule.feedback', 'Message receivers (email, separated by comma)'),
            'notifyEmailFrom' => Yii::t('FeedbackModule.feedback', 'Email message will be send from'),
            'sendConfirmation' => Yii::t('FeedbackModule.feedback', 'Send notification'),
            'successPage' => Yii::t('FeedbackModule.feedback', 'Page after form was sent'),
            'cacheTime' => Yii::t('FeedbackModule.feedback', 'Counter caching time (seconds)'),
            'mainCategory' => Yii::t('FeedbackModule.feedback', 'Main messages category'),
            'minCaptchaLength' => Yii::t('FeedbackModule.feedback', 'Minimum captcha length'),
            'maxCaptchaLength' => Yii::t('FeedbackModule.feedback', 'Maximum captcha length'),
        ];
    }

    /**
     * @return array
     */
    public function getEditableParams()
    {
        return [
            'showCaptcha' => $this->getChoice(),
            'sendConfirmation' => $this->getChoice(),
            'notifyEmailFrom',
            'emails',
            'successPage',
            'cacheTime',
            'mainCategory' => CHtml::listData($this->getCategoryList(), 'id', 'name'),
            'minCaptchaLength',
            'maxCaptchaLength',
        ];
    }

    /**
     * @return array
     */
    public function getEditableParamsGroups()
    {
        return [
            'main' => [
                'label' => Yii::t('FeedbackModule.feedback', 'General module settings'),
                'items' => [
                    'sendConfirmation',
                    'notifyEmailFrom',
                    'emails',
                    'successPage',
                    'cacheTime',
                    'mainCategory',
                ],
            ],
            'captcha' => [
                'label' => Yii::t('FeedbackModule.feedback', 'Captcha settings'),
                'items' => [
                    'showCaptcha',
                    'minCaptchaLength',
                    'maxCaptchaLength',
                ],
            ],
        ];
    }

    /**
     * @return array|bool
     */
    public function checkSelf()
    {
        $messages = [];

        if (in_array(FeedbackModule::BACKEND_EMAIL, $this->backEnd) && (!$this->emails || !count(
                    explode(',', $this->emails)
                ))
        ) {
            $messages[WebModule::CHECK_ERROR][] = [
                'type' => WebModule::CHECK_ERROR,
                'message' => Yii::t(
                    'FeedbackModule.feedback',
                    'Select feedback message email receivers (emails) {link}',
                    [
                        '{link}' => CHtml::link(
                            Yii::t('FeedbackModule.feedback', 'Change module settings'),
                            [
                                '/yupe/backend/modulesettings/',
                                'module' => $this->id,
                            ]
                        ),
                    ]
                ),
            ];
        }

        if (!$this->notifyEmailFrom) {
            $messages[WebModule::CHECK_ERROR][] = [
                'type' => WebModule::CHECK_ERROR,
                'message' => Yii::t(
                    'FeedbackModule.feedback',
                    'Select email which will be display in "From" field {link}',
                    [
                        '{link}' => CHtml::link(
                            Yii::t('FeedbackModule.feedback', 'Change module settings'),
                            [
                                '/yupe/backend/modulesettings/',
                                'module' => $this->id,
                            ]
                        ),
                    ]
                ),
            ];
        }

        $count = FeedBack::model()->new()->cache($this->cacheTime)->count();

        if ($count) {
            $messages[WebModule::CHECK_NOTICE][] = [
                'type' => WebModule::CHECK_NOTICE,
                'message' => Yii::t(
                        'FeedbackModule.feedback',
                        'You have {{count}} ',
                        [
                            '{{count}}' => $count,
                        ]
                    ).Yii::t(
                        'FeedbackModule.feedback',
                        'new message |new messages |new messages ',
                        $count
                    ).' '.CHtml::link(
                        Yii::t('FeedbackModule.feedback', 'Show and reply?'),
                        [
                            '/feedback/feedbackBackend/index/',
                            'order' => 'status.asc',
                            'FeedbBack_sort' => 'status',
                        ]
                    ),
            ];
        }

        return (isset($messages[WebModule::CHECK_ERROR]) || isset($messages[WebModule::CHECK_NOTICE])) ? $messages : true;
    }

    /**
     * @return string
     */
    public function getAdminPageLink()
    {
        return '/feedback/feedbackBackend/index';
    }

    /**
     * @return array
     */
    public function getNavigation()
    {
        return [
            [
                'icon' => 'fa fa-fw fa-list-alt',
                'label' => Yii::t('FeedbackModule.feedback', 'Messages list'),
                'url' => ['/feedback/feedbackBackend/index'],
            ],
            [
                'icon' => 'fa fa-fw fa-plus-square',
                'label' => Yii::t('FeedbackModule.feedback', 'Create message'),
                'url' => ['/feedback/feedbackBackend/create'],
            ],
            [
                'icon' => 'fa fa-fw fa-folder-open',
                'label' => Yii::t('FeedbackModule.feedback', 'Messages categories'),
                'url' => ['/category/categoryBackend/index', 'Category[parent_id]' => (int)$this->mainCategory],
            ],
        ];
    }

    /**
     * @return string
     */
    public function getName()
    {
        return Yii::t('FeedbackModule.feedback', 'Feedback');
    }

    /**
     * @return string
     */
    public function getCategory()
    {
        return Yii::t('FeedbackModule.feedback', 'Services');
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return Yii::t('FeedbackModule.feedback', 'Module for feedback management');
    }

    /**
     * @return string
     */
    public function getVersion()
    {
        return self::VERSION;
    }

    /**
     * @return string
     */
    public function getAuthor()
    {
        return Yii::t('FeedbackModule.feedback', 'yupe team');
    }

    /**
     * @return string
     */
    public function getAuthorEmail()
    {
        return Yii::t('FeedbackModule.feedback', 'team@yupe.ru');
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return Yii::t('FeedbackModule.feedback', 'http://yupe.ru');
    }

    /**
     * @return string
     */
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

    /**
     *
     */
    public function init()
    {
        parent::init();

        $this->setImport(
            [
                'feedback.models.*',
                'feedback.components.*',
            ]
        );

        if (!$this->emails) {
            $this->emails = Yii::app()->getModule('yupe')->email;
        }
    }

    /**
     * @return array
     */
    public function getTypes()
    {
        return is_array($this->types) ? $this->types : [];
    }

    /**
     * @return array
     */
    public function getAuthItems()
    {
        return [
            [
                'name' => 'Feedback.FeedbackManager',
                'description' => Yii::t('FeedbackModule.feedback', 'Manage feedback'),
                'type' => AuthItem::TYPE_TASK,
                'items' => [
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'Feedback.FeedbackBackend.Create',
                        'description' => Yii::t('FeedbackModule.feedback', 'Creating feedback'),
                    ],
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'Feedback.FeedbackBackend.Delete',
                        'description' => Yii::t('FeedbackModule.feedback', 'Removing feedback'),
                    ],
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'Feedback.FeedbackBackend.Index',
                        'description' => Yii::t('FeedbackModule.feedback', 'List of feedback'),
                    ],
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'Feedback.FeedbackBackend.Update',
                        'description' => Yii::t('FeedbackModule.feedback', 'Editing feedback'),
                    ],
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'Feedback.FeedbackBackend.View',
                        'description' => Yii::t('FeedbackModule.feedback', 'Viewing feedback'),
                    ],
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'Feedback.FeedbackBackend.Answer',
                        'description' => Yii::t('FeedbackModule.feedback', 'Answer feedback'),
                    ],
                ],
            ],
        ];
    }

}
