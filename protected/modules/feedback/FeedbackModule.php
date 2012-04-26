<?php
class FeedbackModule extends YWebModule
{
    public $backEnd;
    public $emails;
    public $types;
    public $showCaptcha = 1; 
    public $notifyEmailFrom;
    public $sendConfirmation = 0;
    public $successPage;
    public $cacheTime = 60;
    
    const BACKEND_EMAIL = 'email';
    const BACKEND_DB    = 'db';

    public static $logCategory = 'application.modules.feedback';

    public function getParamsLabels()
    {
        return array(
            'showCaptcha'=> Yii::t('feedback', 'Показывать капчу'),
            'emails'           => Yii::t('feedback','Получатели сообщений с сайта (email через запятую)'),
            'notifyEmailFrom'  => Yii::t('feedback','Email от имени которого отправлять сообщение'),            
            'adminMenuOrder'   => Yii::t('feedback','Порядок следования в меню'),
            'sendConfirmation' => Yii::t('feedback','Отправлять подтверждение'),
            'successPage'      => Yii::t('feedback','Страница после отправки формы'),
            'cacheTime'        => Yii::t('feedback','Время кэширования счетчика (сек.)')
        );
    }

    public function getEditableParams()
    {
        return array(
            'showCaptcha' => $this->getChoice(),
            'sendConfirmation' => $this->getChoice(),
            'notifyEmailFrom',
            'emails',
            'adminMenuOrder',
            'successPage',
            'cacheTime'            
        );
    }

    public function checkSelf()
    {
        if (!is_array($this->backEnd) || !count($this->backEnd) || (!in_array(FeedbackModule::BACKEND_DB, $this->backEnd) && !in_array(FeedbackModule::BACKEND_EMAIL, $this->backEnd)))
            return array('type' => YWebModule::CHECK_ERROR,'message' => Yii::t('feedback','Укажите куда отправлять сообщения обратной связи на email или сохранять в базу данных (Настройка backEnd в config/main.php)'));
        
        if (in_array(FeedbackModule::BACKEND_EMAIL, $this->backEnd) && (!$this->emails || !count(explode(',',$this->emails))))        
            return array('type' => YWebModule::CHECK_ERROR,'message' => Yii::t('feedback','Укажите на какие email отправлять сообщения обратной связи (emails) {link}',array('{link}' => CHtml::link(Yii::t('image', 'Изменить настройки модуля'), array('/yupe/backend/modulesettings/', 'module' => $this->id)))));

        if (!$this->notifyEmailFrom)
            return array('type' => YWebModule::CHECK_ERROR,'message' => Yii::t('feedback','Укажите с какого email отправлять сообщения обратной связи {link}',array('{link}' => CHtml::link(Yii::t('image', 'Изменить настройки модуля'), array('/yupe/backend/modulesettings/', 'module' => $this->id)))));
    }

    public function getName()
    {
        $count = FeedBack::model()->new()->cache($this->cacheTime)->count();
        return $count ? Yii::t('feedback', 'Сообщения с сайта') . " ($count)"
            : Yii::t('feedback', 'Сообщения с сайта');
    }

    public function getDescription()
    {
        return Yii::t('feedback', 'Модуль для работы с сообщениями с сайта');
    }

    public function getVersion()
    {
        return Yii::t('feedback', '0.4');
    }

    public function getAuthor()
    {
        return Yii::t('feedback', 'yupe team');
    }

    public function getAuthorEmail()
    {
        return Yii::t('feedback', 'team@yupe.ru');
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

        $this->setImport(array('feedback.models.*','feedback.components.*'));

        if(!$this->emails)
            $this->emails = Yii::app()->getModule('yupe')->email;
    }
}