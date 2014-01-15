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
    public $backEnd          = array('email', 'db');
    public $emails;
    public $types;
    public $showCaptcha      = 0;
    public $notifyEmailFrom;
    public $sendConfirmation = 0;
    public $successPage;
    public $cacheTime        = 60;   
    public $minCaptchaLength = 3;
    public $maxCaptchaLength = 6;

    const BACKEND_EMAIL = 'email';
    const BACKEND_DB    = 'db';

    public static $logCategory = 'application.modules.feedback';

    public function getDependencies()
    {
        return array(
            'category'
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
            'mainCategory' => CHtml::listData($this->getCategoryList(),'id','name'),
            'minCaptchaLength',
            'maxCaptchaLength'
        );
    }

    public function getEditableParamsGroups()
    {
        return array(
            'main' => array(
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

        if (!is_array($this->backEnd) || !count($this->backEnd) || (!in_array(FeedbackModule::BACKEND_DB, $this->backEnd) && !in_array(FeedbackModule::BACKEND_EMAIL, $this->backEnd)))
            $messages[WebModule::CHECK_ERROR][] = array(
                'type'    => WebModule::CHECK_ERROR,
                'message' => Yii::t('FeedbackModule.feedback', 'Select email which messages was sent or select DB for saving messages (Parameter backEnd in config/main.php)'),
            );

        if (in_array(FeedbackModule::BACKEND_EMAIL, $this->backEnd) && (!$this->emails || !count(explode(',', $this->emails))))
            $messages[WebModule::CHECK_ERROR][] = array(
                'type'    => WebModule::CHECK_ERROR,
                'message' => Yii::t('FeedbackModule.feedback', 'Select feedback message email receivers (emails) {link}', array(
                    '{link}' => CHtml::link(Yii::t('FeedbackModule.feedback', 'Change module settings'), array(
                        '/yupe/backend/modulesettings/',
                        'module' => $this->id,
                    )),
                )),
            );

        if (!$this->notifyEmailFrom)
            $messages[WebModule::CHECK_ERROR][] = array(
                'type'    => WebModule::CHECK_ERROR,
                'message' => Yii::t('FeedbackModule.feedback', 'Select email which will be display in "From" field {link}', array(
                    '{link}' => CHtml::link(Yii::t('FeedbackModule.feedback', 'Change module settings'), array(
                        '/yupe/backend/modulesettings/',
                        'module' => $this->id,
                     )),
                )),
            );

        $count = FeedBack::model()->new()->cache($this->cacheTime)->count();
        if ($count)
            $messages[WebModule::CHECK_NOTICE][] = array(
                'type'    => WebModule::CHECK_NOTICE,
                'message' => Yii::t('FeedbackModule.feedback', 'You have {{count}} ', array(
                    '{{count}}' => $count
                 )) . Yii::t('FeedbackModule.feedback', 'new message |new messages |new messages ', $count) . ' ' . CHtml::link(Yii::t('FeedbackModule.feedback', 'Show and reply?'), array(
                    '/feedback/feedbackBackend/index/', 'order' => 'status.asc', 'FeedbBack_sort' => 'status'
                 ))
            );

        return (isset($messages[WebModule::CHECK_ERROR]) || isset($messages[WebModule::CHECK_NOTICE]) ) ? $messages : true;
    }

    public function getAdminPageLink()
    {
        return '/feedback/feedbackBackend/index';
    }

    public function getNavigation()
    {
        return array(
            array('icon' => 'list-alt', 'label' => Yii::t('FeedbackModule.feedback', 'Messages list'), 'url' => array('/feedback/feedbackBackend/index')),
            array('icon' => 'plus-sign', 'label' => Yii::t('FeedbackModule.feedback', 'Create message'), 'url' => array('/feedback/feedbackBackend/create')),
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
        return Yii::t('FeedbackModule.feedback', '0.6');
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
        return 'envelope';
    }
   
    public function init()
    {
        parent::init();

        if (!$this->types) {
            $this->types = array(
                1 => Yii::t('FeedbackModule.feedback', 'Error on site'),
                2 => Yii::t('FeedbackModule.feedback', 'Collaboration Suggest'),
                3 => Yii::t('FeedbackModule.feedback', 'Other...'),
            );
        }

        $this->setImport(array(
            'feedback.models.*',
            'feedback.components.*'
        ));

        if (!$this->emails) {
            $this->emails = Yii::app()->getModule('yupe')->email;
        }
    }
}