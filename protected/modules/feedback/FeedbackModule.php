<?php

class FeedbackModule extends YWebModule
{
    public $backEnd;
    public $emails;
    public $types;
    public $showCaptcha = true;
    public $notifyEmailFrom;
    public $sendConfirmation = false;
    public static $logCategory = 'application.modules.feedback';

    public function getParamsLabels()
    {
        return array(
            'showCaptcha'=> Yii::t('feedback', 'Показывать капчу'),
            'notifyEmailFrom'=> Yii::t('feedback', 'Email от имени которого отправлять сообщение'),
            'adminMenuOrder'   => Yii::t('feedback', 'Порядок следования в меню'),
            'sendConfirmation' => Yii::t('feedback','Отправлять подтверждение')
        );
    }

    public function getEditableParams()
    {
        return array('showCaptcha', 'notifyEmailFrom', 'adminMenuOrder','sendConfirmation');
    }

    public function getName()
    {
        $count = FeedBack::model()->new()->cache(5)->count();
        return $count ? Yii::t('feedback', 'Сообщения с сайта') . " ($count)"
            : Yii::t('feedback', 'Сообщения с сайта');
    }

    public function getDescription()
    {
        return Yii::t('feedback', 'Модуль для работы с сообщениями с сайта');
    }

    public function getVersion()
    {
        return Yii::t('feedback', '0.2');
    }

    public function getAuthor()
    {
        return Yii::t('feedback', 'xoma');
    }

    public function getAuthorEmail()
    {
        return Yii::t('feedback', 'aopeykin@yandex.ru');
    }

    public function getUrl()
    {
        return Yii::t('feedback', 'http://yupe.ru');
    }

    public function getCategory()
    {
        return Yii::t('feedback', 'Обратная связь');
    }

    public function init()
    {
        parent::init();

        if (!is_array($this->backEnd) || !count($this->backEnd) || (!in_array('db', $this->backEnd) && !in_array('email', $this->backEnd)))
        {
            throw new CException(Yii::t('feedback', 'Укажите корректное значение для свойтсва application.modules.feedback.FeedBackModule.backEnd - "db" и/или "email"!'));
        }

        if (in_array('email', $this->backEnd) && (!is_array($this->emails) || !count($this->emails)))
        {
            throw new CException(Yii::t('feedback', 'Укажите email для обратной связи! application.modules.feedback.FeedBackModule.emails'));
        }

        $this->setImport(array(
                              'feedback.models.*',
                              'feedback.components.*',
                         ));
    }
}
