<?php

class MailModule extends YWebModule
{
     public function  getVersion()
    {
        return '0.1';
    }

    public function getCategory()
    {
        return Yii::t('mail', 'Система');
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
        return '/mail/default/';
    }   

    public function getNavigation()
    {
        return array(
            Yii::t('queue', 'Почтовые события') => '/mail/eventAdmin/',
            Yii::t('queue', 'Почтовые шаблоны') => '/mail/templateAdmin/'
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
