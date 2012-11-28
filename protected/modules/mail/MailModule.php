<?php

class MailModule extends YWebModule
{
     public function  getVersion()
    {
        return '0.1 (dev)';
    }

    public function getCategory()
    {
        return Yii::t('mail', 'Сервисы');
    }

    public function getName()
    {
        return Yii::t('mail', 'Почтовые сообщения');
    }

    public function getDescription()
    {
        return Yii::t('mail', 'Модуль управления почтовыми сообщениями');
    }

    public function getAuthor()
    {
        return Yii::t('mail', 'yupe team');
    }

    public function getAuthorEmail()
    {
        return Yii::t('mail', 'team@yupe.ru');
    }

    public function getUrl()
    {
        return Yii::t('mail', 'http://yupe.ru');
    }

    public function getIcon()
    {
        return 'envelope';
    }

    public function getAdminPageLink()
    {
        return '/mail/default/index';
    }

    public function getNavigation()
    {
        return array(
            array('label' => Yii::t('mail', 'Почтовые события')),
            array('icon' => 'list-alt', 'label' => Yii::t('mail', 'Список событий'), 'url'=>array('/mail/eventAdmin/index')),
            array('icon' => 'plus-sign', 'label' => Yii::t('mail', 'Добавить событие'), 'url' => array('/mail/eventAdmin/create')),
            array('label' => Yii::t('mail', 'Почтовые шаблоны')),
            array('icon'=> 'list-alt', 'label' => Yii::t('mail', 'Список шаблонов'), 'url'=>array('/mail/templateAdmin/index')),
            array('icon'=> 'plus-sign', 'label' => Yii::t('mail', 'Добавить шаблон'), 'url' => array('/mail/templateAdmin/create')),
        );
    }

    public function init()
    {
        $this->setImport(array(
            'mail.models.*',
            'mail.components.*',
        ));

        parent::init();
    }
}
