<?php
/**
 * MailModule
 * Класс модуля Mail:
 *
 * @category YupeModules
 * @package  YupeCMS
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @version  0.1
 * @link     http://yupe.ru
 **/

/**
 * MailModule
 * Класс модуля Mail:
 *
 * @category YupeModules
 * @package  YupeCMS
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @version  0.1
 * @link     http://yupe.ru
 **/
class MailModule extends YWebModule
{
    /**
     * Метод получения версии:
     *
     * @return string version
     **/
    public function getVersion()
    {
        return Yii::t('MailModule.mail', '0.1');
    }

    /**
     * Метод получения категории:
     *
     * @return string category
     **/
    public function getCategory()
    {
        return Yii::t('MailModule.mail', 'Сервисы');
    }

    /**
     * Метод получения названия модуля:
     *
     * @return string name
     **/
    public function getName()
    {
        return Yii::t('MailModule.mail', 'Почтовые сообщения');
    }

    /**
     * Метод получения описвния модуля:
     *
     * @return string description
     **/
    public function getDescription()
    {
        return Yii::t('MailModule.mail', 'Модуль управления почтовыми сообщениями');
    }

    /**
     * Метод получения автора модуля:
     *
     * @return string author
     **/
    public function getAuthor()
    {
        return Yii::t('MailModule.mail', 'yupe team');
    }

    /**
     * Метод получения почты автора модуля:
     *
     * @return string author mail
     **/
    public function getAuthorEmail()
    {
        return Yii::t('MailModule.mail', 'team@yupe.ru');
    }

    /**
     * Метод получения ссылки на сайт автора модуля:
     *
     * @return string author url
     **/
    public function getUrl()
    {
        return Yii::t('MailModule.mail', 'http://yupe.ru');
    }

    /**
     * Метод получения иконки:
     *
     * @return string icon
     **/
    public function getIcon()
    {
        return 'envelope';
    }

    /**
     * Метод получения адреса модуля в админ панели:
     *
     * @return string admin url
     **/
    public function getAdminPageLink()
    {
        return '/mail/eventAdmin/index';
    }

    /**
     * Метод получения меню модуля (для навигации):
     *
     * @return mixed navigation of module
     **/
    public function getNavigation()
    {
        return array(
            array('label' => Yii::t('MailModule.mail', 'Почтовые события')),
            array('icon' => 'list-alt', 'label' => Yii::t('MailModule.mail', 'Список событий'), 'url'=>array('/mail/eventAdmin/index')),
            array('icon' => 'plus-sign', 'label' => Yii::t('MailModule.mail', 'Добавить событие'), 'url' => array('/mail/eventAdmin/create')),
            array('label' => Yii::t('MailModule.mail', 'Почтовые шаблоны')),
            array('icon'=> 'list-alt', 'label' => Yii::t('MailModule.mail', 'Список шаблонов'), 'url'=>array('/mail/templateAdmin/index')),
            array('icon'=> 'plus-sign', 'label' => Yii::t('MailModule.mail', 'Добавить шаблон'), 'url' => array('/mail/templateAdmin/create')),
        );
    }

    /**
     * Метод инициализации модуля:
     *
     * @return nothing
     **/
    public function init()
    {
        $this->setImport(
            array(
                'mail.models.*',
                'mail.components.*',
            )
        );

        parent::init();
    }

    /**
     * Указываем, что модуль не отключаемый
     *
     * @return boolean
     **/
    public function getIsNoDisable()
    {
        return true;
    }

    /**
     * Указываем, что модуль будет установлен поумолчанию:
     *
     * @return boolean
     **/
    public function getIsInstallDefault()
    {
        return true;
    }

    /**
     * Получаем массив с именами модулей, от которых зависит работа данного модуля
     * 
     * @return array Массив с именами модулей, от которых зависит работа данного модуля
     * 
     * @since 0.5
     */
    public function getDependencies()
    {
        return array('user');
    }
}