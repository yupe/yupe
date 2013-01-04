<?php
class FeedbackModule extends YWebModule
{
    public $backEnd          = array('email', 'db');
    public $emails;
    public $types;
    public $showCaptcha      = 1;
    public $notifyEmailFrom;
    public $sendConfirmation = 0;
    public $successPage;
    public $cacheTime        = 60;

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
            'showCaptcha'      => Yii::t('feedback', 'Показывать капчу'),
            'emails'           => Yii::t('feedback', 'Получатели сообщений с сайта (email через запятую)'),
            'notifyEmailFrom'  => Yii::t('feedback', 'Email от имени которого отправлять сообщение'),
            'adminMenuOrder'   => Yii::t('feedback', 'Порядок следования в меню'),
            'sendConfirmation' => Yii::t('feedback', 'Отправлять подтверждение'),
            'successPage'      => Yii::t('feedback', 'Страница после отправки формы'),
            'cacheTime'        => Yii::t('feedback', 'Время кэширования счетчика (сек.)'),
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
        );
    }

    public function checkSelf()
    {
        $messages = array();

        if (!is_array($this->backEnd) || !count($this->backEnd) || (!in_array(FeedbackModule::BACKEND_DB, $this->backEnd) && !in_array(FeedbackModule::BACKEND_EMAIL, $this->backEnd)))
            $messages[YWebModule::CHECK_ERROR][] = array(
                'type'    => YWebModule::CHECK_ERROR,
                'message' => Yii::t('feedback', 'Укажите куда отправлять сообщения обратной связи на email или сохранять в базу данных (Настройка backEnd в config/main.php)'),
            );

        if (in_array(FeedbackModule::BACKEND_EMAIL, $this->backEnd) && (!$this->emails || !count(explode(',', $this->emails))))
            $messages[YWebModule::CHECK_ERROR][] = array(
                'type'    => YWebModule::CHECK_ERROR,
                'message' => Yii::t('feedback', 'Укажите на какие email отправлять сообщения обратной связи (emails) {link}', array(
                    '{link}' => CHtml::link(Yii::t('feedback', 'Изменить настройки модуля'), array(
                        '/yupe/backend/modulesettings/',
                        'module' => $this->id,
                    )),
                )),
            );

        if (!$this->notifyEmailFrom)
            $messages[YWebModule::CHECK_ERROR][] = array(
                'type'    => YWebModule::CHECK_ERROR,
                'message' => Yii::t('feedback', 'Укажите с какого email отправлять сообщения обратной связи {link}', array(
                    '{link}' => CHtml::link(Yii::t('feedback', 'Изменить настройки модуля'), array(
                        '/yupe/backend/modulesettings/',
                        'module' => $this->id,
                     )),
                )),
            );

        $count = FeedBack::model()->new()->cache($this->cacheTime)->count();
        if ($count)
            $messages[YWebModule::CHECK_NOTICE][] = array(
                'type'    => YWebModule::CHECK_NOTICE,
                'message' => Yii::t('feedback', 'У Вас {{count}} ', array(
                    '{{count}}' => $count
                 )) . Yii::t('feedback', "новое сообщение с сайта|новых сообщения с сайта|новых сообщений с сайта", $count) . ' ' . CHtml::link(Yii::t('feedback', 'Посмотреть и ответить?'), array(
                    '/feedback/default/admin/order/status.asc/FeedbBack_sort/status/',
                 ))
            );

        return (isset($messages[YWebModule::CHECK_ERROR]) || isset($messages[YWebModule::CHECK_NOTICE]) ) ? $messages : true;
    }

    public function getNavigation()
    {
        return array(
            array('icon' => 'list-alt', 'label' => Yii::t('feedback', 'Список сообщений'), 'url' => array('/feedback/default/index')),
            array('icon' => 'plus-sign', 'label' => Yii::t('feedback', 'Добавить сообщение'), 'url' => array('/feedback/default/create')),
        );
    }

    public function getName()
    {
        return Yii::t('feedback', 'Сообщения с сайта');
    }

    public function getCategory()
    {
        return Yii::t('feedback', 'Сервисы');
    }

    public function getDescription()
    {
        return Yii::t('feedback', 'Модуль для работы с сообщениями с сайта');
    }

    public function getVersion()
    {
        return Yii::t('feedback', '0.5');
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

    public function getIcon()
    {
        return 'envelope';
    }

    public function init()
    {
        parent::init();

        if (!$this->types)
            $this->types = array(
                1 => Yii::t('feedback', 'Ошибка на сайте'),
                2 => Yii::t('feedback', 'Предложение о сотрудничестве'),
                3 => Yii::t('feedback', 'Прочее..'),
            );

        $this->setImport(array('feedback.models.*', 'feedback.components.*'));

        if (!$this->emails)
            $this->emails = Yii::app()->getModule('yupe')->email;
    }
}