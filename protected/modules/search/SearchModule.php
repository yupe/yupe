<?php
class SearchModule extends YWebModule
{
    protected $info=false;

    public function getEditableParams()
    {
        return array(
//            'param',
        );
    }

    public function getParamsLabels()
    {
        return array(
            'param' => Yii::t('email',''),
        );
    }

	public function getCategory()
    {
        return Yii::t('email', 'Сервисы');
    }

    public function getName()
    {
        return Yii::t('email', 'E-Mail');
    }

    public function getDescription()
    {
        return Yii::t('email', 'Функции сайта E-Mail.ru.');
    }

    public function getAuthor()
    {
        return Yii::t('email', 'Archaron');
    }

    public function getAuthorEmail()
    {
        return Yii::t('email', 'tsm@glavset.ru');
    }

    public function getUrl()
    {
        return Yii::t('email', 'http://yupe.ru/');
    }

    public function getAdminPageLink()
    {
        return '/email/default/';
    }

    public function getIcon()
    {
        return "globe";
    }

    public function init()
    {
        parent::init();
        $this->setImport(array(
            'email.models.*',
            'email.components.*',
        ));
    }

    public static function onBeginRegistration($event)
    {

    }

    public static function onBeginProfile($event)
    {
        /** @var CEvent $event */
        $profile = emailProfile::model()->findByPk(Yii::app()->user-> id);
        $profile = $profile?$profile:new emailProfile;
        $profile->user_id = Yii::app()->user-> id;

        // Если идет сохранение профиля
        if (isset($_POST['emailProfile']))
        {
            $profile->attributes = $_POST['emailProfile'];
            $profile->user_id = Yii::app()->user-> id;

            // Тут можно делать дополнительные манипуляции с профилем
        }
        $event-> sender-> module-> profiles['email'] = $profile;
        return true;
    }


}