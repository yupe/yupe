<?php

class MailModule extends YWebModule
{
    public function  getVersion()
    {
        return Yii::t('MailModule.mail', '0.1');
    }

    public function getCategory()
    {
        return Yii::t('MailModule.mail', 'Сервисы');
    }
    
    public function getCategoryType()
    {
    	return Yii::t('MailModule.mail', 'services');
    }

    public function getName()
    {
        return Yii::t('MailModule.mail', 'Почтовые сообщения');
    }

    public function getDescription()
    {
        return Yii::t('MailModule.mail', 'Модуль управления почтовыми сообщениями');
    }

    public function getAuthor()
    {
        return Yii::t('MailModule.mail', 'yupe team');
    }

    public function getAuthorEmail()
    {
        return Yii::t('MailModule.mail', 'team@yupe.ru');
    }

    public function getUrl()
    {
        return Yii::t('MailModule.mail', 'http://yupe.ru');
    }

    public function getIcon()
    {
        return 'envelope';
    }

    public function getNavigation()
    {
        return array(
        	array('label' => Yii::t('MailModule.mail', 'Почтовые сообщения')),
        	array('icon'=> 'list-alt', 'label' => Yii::t('MailModule.mail','Управление'),'url'=>array('/mail/defaultAdmin/index')),
            array('label' => Yii::t('MailModule.mail', 'Почтовые события')),
            array('icon' => 'list-alt', 'label' => Yii::t('MailModule.mail', 'Список событий'), 'url'=>array('/mail/eventAdmin/index')),
            array('icon' => 'plus-sign', 'label' => Yii::t('MailModule.mail', 'Добавить событие'), 'url' => array('/mail/eventAdmin/create')),
            array('label' => Yii::t('MailModule.mail', 'Почтовые шаблоны')),
            array('icon'=> 'list-alt', 'label' => Yii::t('MailModule.mail', 'Список шаблонов'), 'url'=>array('/mail/templateAdmin/index')),
            array('icon'=> 'plus-sign', 'label' => Yii::t('MailModule.mail', 'Добавить шаблон'), 'url' => array('/mail/templateAdmin/create')),
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