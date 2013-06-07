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
    public $mainCategory;
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
            'showCaptcha'      => Yii::t('FeedbackModule.feedback', 'Показывать капчу'),
            'emails'           => Yii::t('FeedbackModule.feedback', 'Получатели сообщений (email через запятую)'),
            'notifyEmailFrom'  => Yii::t('FeedbackModule.feedback', 'Email от имени которого отправлять сообщение'),
            'adminMenuOrder'   => Yii::t('FeedbackModule.feedback', 'Порядок следования в меню'),
            'sendConfirmation' => Yii::t('FeedbackModule.feedback', 'Отправлять подтверждение'),
            'successPage'      => Yii::t('FeedbackModule.feedback', 'Страница после отправки формы'),
            'cacheTime'        => Yii::t('FeedbackModule.feedback', 'Время кэширования счетчика (сек.)'),
            'mainCategory'     => Yii::t('FeedbackModule.feedback', 'Главная категория сообщений'),
            'minCaptchaLength' => Yii::t('FeedbackModule.feedback', 'Минимальная длинна капчи'),
            'maxCaptchaLength' => Yii::t('FeedbackModule.feedback', 'Максимальная длинна капчи'),
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
                'label' => Yii::t('YupeModule.yupe', 'Основные настройки модуля'),
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
                'label' => Yii::t('YupeModule.yupe', 'Настройки капчи'),
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
            $messages[YWebModule::CHECK_ERROR][] = array(
                'type'    => YWebModule::CHECK_ERROR,
                'message' => Yii::t('FeedbackModule.feedback', 'Укажите куда отправлять сообщения обратной связи на email или сохранять в базу данных (Настройка backEnd в config/main.php)'),
            );

        if (in_array(FeedbackModule::BACKEND_EMAIL, $this->backEnd) && (!$this->emails || !count(explode(',', $this->emails))))
            $messages[YWebModule::CHECK_ERROR][] = array(
                'type'    => YWebModule::CHECK_ERROR,
                'message' => Yii::t('FeedbackModule.feedback', 'Укажите на какие email отправлять сообщения обратной связи (emails) {link}', array(
                    '{link}' => CHtml::link(Yii::t('FeedbackModule.feedback', 'Изменить настройки модуля'), array(
                        '/yupe/backend/modulesettings/',
                        'module' => $this->id,
                    )),
                )),
            );

        if (!$this->notifyEmailFrom)
            $messages[YWebModule::CHECK_ERROR][] = array(
                'type'    => YWebModule::CHECK_ERROR,
                'message' => Yii::t('FeedbackModule.feedback', 'Укажите с какого email отправлять сообщения обратной связи {link}', array(
                    '{link}' => CHtml::link(Yii::t('FeedbackModule.feedback', 'Изменить настройки модуля'), array(
                        '/yupe/backend/modulesettings/',
                        'module' => $this->id,
                     )),
                )),
            );

        $count = FeedBack::model()->new()->cache($this->cacheTime)->count();
        if ($count)
            $messages[YWebModule::CHECK_NOTICE][] = array(
                'type'    => YWebModule::CHECK_NOTICE,
                'message' => Yii::t('FeedbackModule.feedback', 'У Вас {{count}} ', array(
                    '{{count}}' => $count
                 )) . Yii::t('FeedbackModule.feedback', "новое сообщение  |новых сообщения  |новых сообщений  ", $count) . ' ' . CHtml::link(Yii::t('FeedbackModule.feedback', 'Посмотреть и ответить?'), array(
                    '/feedback/default/index/order/status.asc/FeedbBack_sort/status/',
                 ))
            );

        return (isset($messages[YWebModule::CHECK_ERROR]) || isset($messages[YWebModule::CHECK_NOTICE]) ) ? $messages : true;
    }

    public function getNavigation()
    {
        return array(
            array('icon' => 'list-alt', 'label' => Yii::t('FeedbackModule.feedback', 'Список сообщений'), 'url' => array('/feedback/default/index')),
            array('icon' => 'plus-sign', 'label' => Yii::t('FeedbackModule.feedback', 'Добавить сообщение'), 'url' => array('/feedback/default/create')),
        );
    }

    public function getName()
    {
        return Yii::t('FeedbackModule.feedback', 'Сообщения с сайта');
    }

    public function getCategory()
    {
        return Yii::t('FeedbackModule.feedback', 'Сервисы');
    }

    public function getDescription()
    {
        return Yii::t('FeedbackModule.feedback', 'Модуль для работы с сообщениями');
    }

    public function getVersion()
    {
        return Yii::t('FeedbackModule.feedback', '0.5.1');
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

    public function getCategoryList()
    {
        $criteria = ($this->mainCategory)
            ? array(
                'condition' => 'id = :id OR parent_id = :id',
                'params'    => array(':id' => $this->mainCategory),
                'order'     => 'id ASC',
            )
            : array();

        return Category::model()->findAll($criteria);
    }

    public function init()
    {
        parent::init();

        if (!$this->types)
            $this->types = array(
                1 => Yii::t('FeedbackModule.feedback', 'Ошибка на сайте'),
                2 => Yii::t('FeedbackModule.feedback', 'Предложение о сотрудничестве'),
                3 => Yii::t('FeedbackModule.feedback', 'Прочее..'),
            );

        $this->setImport(array('feedback.models.*', 'feedback.components.*'));

        if (!$this->emails)
            $this->emails = Yii::app()->getModule('yupe')->email;
    }
}