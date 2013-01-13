<?php
class GeoModule extends YWebModule
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
            'param' => Yii::t('GeoModule.geo', ''),
        );
    }

	public function getCategory()
    {
        return Yii::t('GeoModule.geo', 'Сервисы');
    }

    public function getName()
    {
        return Yii::t('GeoModule.geo', 'ГЕО-Локация');
    }

    public function getDescription()
    {
        return Yii::t('GeoModule.geo', 'Модуль содержит компоненты и виджеты для работы с базой GeoIP. Добавляет поддержку стран и городов к профилю пользователя.');
    }

    public function getAuthor()
    {
        return 'Archaron';
    }

    public function getAuthorEmail()
    {
        return Yii::t('GeoModule.geo', 'tsm@glavset.ru');
    }

    public function getVersion()
    {
        return Yii::t('GeoModule.geo', '0.1');
    }

    public function getUrl()
    {
        return Yii::t('GeoModule.geo', 'http://yupe.ru/');
    }

    public function getAdminPageLink()
    {
        return '/geo/default/index';
    }

    public function getIcon()
    {
        return "globe";
    }

    public function init()
    {
        parent::init();

        $this->setImport(array(
            'geo.models.*',
            'geo.components.*',
        ));
    }

    public static function onBeginRegistration($event)
    {

    }

    public static function onBeginProfile($event)
    {
        $profile = GeoProfile::model()->findByPk(Yii::app()->user->id);
        $profile = $profile ? $profile : new GeoProfile;
        $profile->user_id = Yii::app()->user->id;

        // Если идет сохранение профиля
        if (isset($_POST['GeoProfile']))
        {
            $profile->attributes = $_POST['GeoProfile'];
            $profile->user_id = Yii::app()->user->id;
            // Тут можно делать дополнительные манипуляции с профилем
        }

        $event->sender->module->profiles['geo'] = $profile;
        return true;
    }

    /**
     *  Возвращает массив с данными о нахождении пользователя
     * @return array массив с данными о нахождении пользователя, false если не удалось определить
     */
    public function getSxInfo()
    {
        if ($this->info)
            return $this->info;

        $ip = Yii::app()->request->getUserHostAddress();
        ($ip != "127.0.0.1" && $ip != "::1") || ($ip = "194.213.102.1");

        $handle = 'SxGeoIP:' . $ip;
        $this->info = Yii::app()->cache->get($handle);

        if ($this->info === false)
        {
            if (!($this->info = Yii::app()->sxgeo->getAll($ip)))
                $this->info = false;

            Yii::app()->cache->set($handle, $this->info, 3600);
        }
        return $this->info;
    }

    public function guessCity()
    {
        $city = false;
        if ($info = $this->sxInfo)
            $city = GeoCity::model()->findByAttributes(array("name" => $info['city']));
        return $city;
    }
}