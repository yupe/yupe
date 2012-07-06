<?php
/**
 * YWebModule - базовый класс для всех модулей Юпи!
 *
 * Все модули, разработанные для Юпи! должны наследовать этот класс.
 * Панель управления Юпи!, собираемая из модулей, использует определенные методы этого базового класса.
 *
 * @package yupe.core.components
 * @abstract
 * @author yupe team
 * @version 0.0.3
 * @link http://yupe.ru - основной сайт
 *
 *
 */
abstract class YWebModule extends CWebModule
{
    const CHECK_ERROR  = 'error';

    const CHECK_NOTICE = 'notice';

    const CHOICE_YES = 1;
    const CHOICE_NO = 0;

    /**
     *  @var int порядок следования модуля в меню панели управления (сортировка)
     */
    public $adminMenuOrder = 0;
    /**
     *  @var int некоторые компоненты Юпи! автоматически кэширует, если время жизни кэша не указано - берется это значение
     */
    public $coreCacheTime = 3600;
    /**
     *  @var array правила маршрутизации модуля (импортируются при старте модуля)
     */
    public $urlRules = null;

    /**
     *  @return string текущая версия модуля
     */
    public function getVersion()
    {
        return '0.1';
    }

    /**
     *  @return string веб-сайт разработчика модуля или страничка самого модуля
     */
    public function getUrl()
    {
        return 'http://yupe.ru';
    }

    /**
     *  @return string имя автора модуля
     */
    public function getAuthor()
    {
        return Yii::t('yupe', 'Сообщество Юпи!');
    }

    /**
     *  @return string контактный email автора модуля
     */
    public function getAuthorEmail()
    {
        return 'support@yupe.ru';
    }

    /**
     *  @return string ссылка которая будет отображена в панели управления
     *  как правило, ведет на страничку для администрирования модуля
     */
    public function getAdminPageLink()
    {
        return '/' . strtolower($this->id) . '/' . strtolower($this->defaultController) . '/admin/';
    }

    /**
     * @return array если модуль должен добавить несколько ссылок в панель управления - укажите массив
     * @example
     *
     * public function getNavigation()
     * {
     *       return array(
     *           Yii::t('blog','Блоги')  => '/blog/blogAdmin/admin/',
     *           Yii::t('blog','Записи') => '/blog/postAdmin/admin/',
     *           Yii::t('blog','Участники') => '/blog/BlogToUserAdmin/admin/'
     *      );
     * }
     *
     */
    public function getNavigation()
    {
        return false;
    }

    /**
     *   @return array или false
     *   Работосопособность модуля может зависеть от разных факторов: версия php, версия Yii, наличие определенных модулей и т.д.
     *   В этом методе необходимо выполнить все проверки.
     *   @example
     *
     *   if (!$this->uploadDir)
     *        return array('type' => YWebModule::CHECK_ERROR, 'message' => Yii::t('image', 'Пожалуйста, укажите каталог для хранения изображений! {link}', array('{link}' => CHtml::link(Yii::t('image', 'Изменить настройки модуля'), array('/yupe/backend/modulesettings/', 'module' => $this->id)))));
     *
     *   Данные сообщения выводятся на главной странице панели управления
     *
     */
    public function checkSelf()
    {
        return true;
    }

    /**
     *  @return string каждый модуль должен принадлежать одной категории, именно по категорям делятся модули в панели управления
     */
    public function getCategory()
    {
        return null;
    }

    /**
     *  @return array массив лейблов для параметров (свойств) модуля. Используется на странице настроек модуля в панели управления.
     */
    public function getParamsLabels()
    {
        return array('adminMenuOrder' => Yii::t('yupe', 'Порядок следования в меню'), );
    }

    /**
     *  @return array массив параметров модуля, которые можно редактировать через панель управления (GUI)
     */
    public function getEditableParams()
    {
        return array('adminMenuOrder');
    }

    /**
     *  @return int порядок следования модуля в меню панели управления (сортировка)
     */
    public function getAdminMenuOrder()
    {
        return $this->adminMenuOrder;
    }

    /**
     *  @return bool показать или нет модуль в панели управления
     */

    public function getIsShowInAdminMenu()
    {
        return true;
    }

    /**
     *  @return array для многих параметров модуля необходимо вывести варианты выбора да или нет - метод-хелпер именно для этого
     */
    public function getChoice()
    {
        return array(
            self::CHOICE_YES => Yii::t('yupe', 'да'),
            self::CHOICE_NO => Yii::t('yupe', 'нет')
        );
    }

    /**
     * @return string название иконки для меню админки, например 'user'
     */
    public function getIcon()
    {
        return null;
    }

    /**
     *  инициализация модуля, считывание настроек из базы данных и их кэширование
     */
    public function init()
    {
        if (is_object(Yii::app()->theme))
            $this->layout = 'webroot.themes.' . Yii::app()->theme->name . '.views.layouts.main';

        // инициализация модуля
        $settings = Settings::model()->cache($this->coreCacheTime)->findAll('module_id = :module_id', array('module_id' => $this->getId()));

        if($settings)
        {
            $editableParams = $this->getEditableParams();

            //@TODO обход не settings а editableParams как вариант =)
            foreach ($settings as $model)
            {
                if (property_exists($this, $model->param_name) && (in_array($model->param_name, $editableParams) || array_key_exists($model->param_name, $editableParams)))
                    $this->{$model->param_name} = $model->param_value;
            }
        }

        parent::init();
    }
}
