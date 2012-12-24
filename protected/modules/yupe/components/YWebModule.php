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
 */

abstract class YWebModule extends CWebModule
{
    const CHECK_ERROR  = 'error';
    const CHECK_NOTICE = 'notice';

    const CHOICE_YES = 1;
    const CHOICE_NO  = 0;

    /**
     *  @var int порядок следования модуля в меню панели управления (сортировка)
     */
    public $adminMenuOrder = 0;
    /**
     *  @var int некоторые компоненты Юпи! автоматически кэширует, если время жизни кэша не указано - берется это значение
     */
    public $coreCacheTime  = 3600;
    /**
     *  @var array правила маршрутизации модуля (импортируются при старте модуля)
     */
    public $urlRules       = null;
    /**
     *  @var array редактор
     */
    public $editor         = 'application.modules.yupe.widgets.editors.imperaviRedactor.ImperaviRedactorWidget';
    /**
     *  @var array опции редактора
     */
    public $editorOptions  = array();
    /**
     *  @var bool разрещение на вывод YFlashMessages
     */
    public $flashMess = false;

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
     *  @return string ссылка которая будет отображена в панели управления
     *  как правило, ведет на страничку для администрирования модуля
     */
    public function getAdminPageLinkNormalize()
    {
        return is_array($this->adminPageLink) ? $this->adminPageLink : array($this->adminPageLink);
    }

    /**
     * @return array если модуль должен добавить несколько ссылок в панель управления - укажите массив
     * @example
     *
     * public function getNavigation()
     * {
     *       return array(
     *           Yii::t('blog','Блоги')     => '/blog/blogAdmin/admin/',
     *           Yii::t('blog','Записи')    => '/blog/postAdmin/admin/',
     *           Yii::t('blog','Участники') => '/blog/BlogToUserAdmin/admin/',
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
     *   @todo проработать вывод сразу нескольких ошибок
     *   Работосопособность модуля может зависеть от разных факторов: версия php, версия Yii, наличие определенных модулей и т.д.
     *   В этом методе необходимо выполнить все проверки.
     *   @example
     *   if (!$this->uploadDir)
     *        return array(
     *            'type' => YWebModule::CHECK_ERROR,
     *            'message' => Yii::t('image', 'Пожалуйста, укажите каталог для хранения изображений! {link}', array(
     *                '{link}' => CHtml::link(Yii::t('image', 'Изменить настройки модуля'), array('/yupe/backend/modulesettings/', 'module' => $this->id))
     *            ))
     *        );
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
        return array('adminMenuOrder' => Yii::t('yupe', 'Порядок следования в меню'));
    }

    /**
     *  @return array массив параметров модуля, которые можно редактировать через панель управления (GUI)
     */
    public function getEditableParams()
    {
        return array('adminMenuOrder');
    }

    /**
     *  @return array получение имена парамметров из getEditableParams()
     */
    public function getEditableParamsKey()
    {
        $keyParams = array();
        foreach ($this->editableParams as $key => $value)
            $keyParams[] = is_int($key) ? $value : $key;
        return $keyParams;
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
     *  @return bool определяет, включен или выключен модуль
     *  @since 0.5
     */
    public function getIsStatus()
    {
        $status = is_file(Yii::app()->basePath . '/config/modules/' . $this->id . '.php');
        // @TODO Временный хак, дающий возможность переустановки, после появления обновлению, будет закрыт
        if ($this->id == 'install')
            $status = ($status == false) ? true : false;
        return $status;
    }

    /**
     *  @return bool разрешено ли выключение
     *  @since 0.5
     */
    public function getIsNoDisable()
    {
        return false;
    }

    /**
     *  @return array Массив с именами модулей, от которых зависит работа данного модуля
     *  @since 0.5
     */
    public function getDependencies()
    {
        return array(

        );
    }

    /**
     *  @return bool устанавливает checkbox включенным по умолчанию при установке Yupe
     *  @since 0.5
     */
    public function getIsInstallDefault()
    {
        return true;
    }

    protected function setFlash($type, $message)
    {
        if ($this->flashMess)
            Yii::app()->user->setFlash($type, $message);
    }

    /**
     *  @return bool включает модуль
     *  @since 0.5
     */
    public function getActivate()
    {
        $yupe = Yii::app()->getModule('yupe');
        $fileModule = $yupe->getModulesConfigDefault($this->id);
        $fileConfig = $yupe->getModulesConfig($this->id);

        // @TODO Временный хак, дающий возможность переустановки, после появления обновлению, будет закрыт
        if (is_file($fileConfig) && $this->id != 'install')
            $this->setFlash(
                YFlashMessages::NOTICE_MESSAGE,
                Yii::t('yupe', 'Модуль уже включен!')
            );
        else
        {
            if (@copy($fileModule, $fileConfig))
                $this->setFlash(
                    YFlashMessages::NOTICE_MESSAGE,
                    Yii::t('yupe', 'Модуль включен!')
                );
            else
            {
                $this->setFlash(
                    YFlashMessages::ERROR_MESSAGE,
                    Yii::t('yupe', 'Произошла ошибка при включении модуля, конфигурационный файл поврежден или отсутствует доступ к папке config!')
                );
                return false;
            }
        }
        return true;
    }

    /**
     *  @return bool выключает модуль
     *  @since 0.5
     */
    public function getDeActivate()
    {
        $yupe = Yii::app()->getModule('yupe');
        $fileModule = $yupe->getModulesConfigDefault($this->id);
        $fileConfig = $yupe->getModulesConfig($this->id);

        // @TODO Временный хак, дающий возможность переустановки, после появления обновлению, будет закрыт
        if (!is_file($fileConfig) && $this->id != 'install')
        {
            $this->setFlash(
                YFlashMessages::NOTICE_MESSAGE,
                Yii::t('yupe', 'Модуль уже отключен!')
            );
            return true;
        }
        if (!$this->isNoDisable)
        {
            if (@md5_file($fileModule) != @md5_file($fileConfig))
            {
                $fileConfigBack = $yupe->getModulesConfigBack($this->id);
                if (!@copy($fileConfig, $fileConfigBack))
                    $this->setFlash(
                        YFlashMessages::ERROR_MESSAGE,
                        Yii::t('yupe', 'Произошла ошибка при копировании старого конфигурационного файла в папку modulesBack!')
                    );
            }
            if (@unlink($fileConfig))
            {
                $this->setFlash(
                    YFlashMessages::NOTICE_MESSAGE,
                    Yii::t('yupe', 'Модуль отключен!')
                );
                return true;
            }
            else
                $this->setFlash(
                    YFlashMessages::ERROR_MESSAGE,
                    Yii::t('yupe', 'Произошла ошибка при отключении модуля, нет доступа к конфигурационному файлу!')
                );
        }
        else
            $this->setFlash(
                YFlashMessages::ERROR_MESSAGE,
                Yii::t('yupe', 'Этот модуль запрещено отключать!')
            );
        return false;
    }

    /**
     *  @return bool включает модуль
     *  @since 0.5
     */
    public function getInstall()
    {
        $this->activate;
        return true;
    }

    /**
     *  @return bool выключает модуль
     *  @since 0.5
     */
    public function getUnInstall()
    {
        $this->deactivate;
        return true;
    }

    /**
     *  @return array для многих параметров модуля необходимо вывести варианты выбора да или нет - метод-хелпер именно для этого
     */
    public function getChoice()
    {
        return array(
            self::CHOICE_YES => Yii::t('yupe', 'да'),
            self::CHOICE_NO  => Yii::t('yupe', 'нет'),
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
     * @return bool стутус работы мультиязычности в модуле
     */
    public function isMultiLang()
    {
        return false;
    }

    /**
     *  инициализация модуля, считывание настроек из базы данных и их кэширование
     */
    public function init()
    {
        if (isset(Yii::app()->theme) && is_object(Yii::app()->theme))
            $this->layout = 'webroot.themes.' . Yii::app()->theme->name . '.views.layouts.main';

        $settings = null;

        try
        {
            // инициализация модуля, понимаю, что @ - это зло, но пока это самое простое решение
            $settings = @Settings::model()->cache($this->coreCacheTime)->findAll('module_id = :module_id AND type = :type', array('module_id' => $this->getId(), ':type' => Settings::TYPE_CORE);
        }
        catch (CDbException $e)
        {
            // Если базы нет, берем по-умолчанию, а не падаем в инсталлере - тут все равно падаем так как нотис не ловится кетчем
            $settings = null;
        }

        if ($settings)
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

        $uploadController = '/yupe/backend/AjaxFileUpload';
        $this->editorOptions =  array(
            'imageUpload' => $uploadController,
            'fileUpload'  => $uploadController,
        );
    }
}