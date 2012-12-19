<?php
class SearchModule extends YWebModule
{
    protected $info = false;

    public function getEditableParams()
    {
        return array(
        //    'param',
        );
    }

    public function getParamsLabels()
    {
        return array(
            'param' => Yii::t('search', ''),
        );
    }

    public function getCategory()
    {
        return Yii::t('search', 'Сервисы');
    }

    public function getName()
    {
        return Yii::t('search', 'E-Mail');
    }

    public function getDescription()
    {
        return Yii::t('search', 'Функции сайта E-Mail.ru.');
    }

    public function getAuthor()
    {
        return Yii::t('email', 'Archaron');
    }

    public function getAuthorEmail()
    {
        return Yii::t('search', 'tsm@glavset.ru');
    }

    public function getVersion()
    {
        return Yii::t('search', '0.5');
    }

    public function getUrl()
    {
        return Yii::t('search', 'http://yupe.ru/');
    }

    public function getAdminPageLink()
    {
        return '/';
    }

    public function getIcon()
    {
        return "globe";
    }

    public function getIsInstallDefault()
    {
        return false;
    }

    public function init()
    {
        parent::init();

        $this->setImport(array(
            'search.models.*',
            'search.components.*',
        ));
    }

    public static function onBeginRegistration($event)
    {

    }

    public static function onBeginProfile($event)
    {
        $profile = emailProfile::model()->findByPk(Yii::app()->user->id);
        $profile = $profile ? $profile : new emailProfile;
        $profile->user_id = Yii::app()->user->id;

        // Если идет сохранение профиля
        if (isset($_POST['emailProfile']))
        {
            $profile->attributes = $_POST['emailProfile'];
            $profile->user_id    = Yii::app()->user->id;

            // @TODO Тут можно делать дополнительные манипуляции с профилем
        }
        $event->sender->module->profiles['email'] = $profile;
        return true;
    }
}