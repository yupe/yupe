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
            array('label' => Yii::t('queue', 'Почтовые события')),
            array('icon' => 'plus-sign', 'label' => Yii::t('yupe', 'Добавить почтовое событие'), 'url' => array('/mail/eventAdmin/create/')),
            array('icon' => 'th-list', 'label' => Yii::t('yupe', 'Управление почтовыми событиями'), 'url'=>array('/mail/eventAdmin/index/')),
            array('label' => Yii::t('menu', 'Почтовые шаблоны')),
            array('icon'=> 'plus-sign', 'label' => Yii::t('yupe', 'Добавить почтовый шаблон'), 'url' => array('/mail/templateAdmin/create/')),
            array('icon'=> 'th-list', 'label' => Yii::t('yupe', 'Управление почтовыми шаблонами'), 'url'=>array('/mail/templateAdmin/index/')),
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
