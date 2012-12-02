<?php

class VoteModule extends YWebModule
{
    public function getName()
    {
        return Yii::t('vote', 'Голосование');
    }

    public function getCategory()
    {
        return Yii::t('vote', 'Сервисы');
    }

    public function getDescription()
    {
        return Yii::t('vote', 'Голосование за любой контент');
    }

    public function getNavigation()
    {
        return array(
            array('icon' => 'list-alt', 'label' => Yii::t('vote', 'Управление голосами'), 'url' => array('/vote/default/index')),
            array('icon' => 'plus-sign', 'label' => Yii::t('vote', 'Добавить голос'), 'url' => array('/vote/default/create')),
        );
    }

    public  function getVersion()
    {
        return '0.1 (dev)';
    }

    public function getAuthor()
    {
        return Yii::t('vote', 'yupe team');
    }

    public function getAuthorEmail()
    {
        return Yii::t('vote', 'team@yupe.ru');
    }

    public function getUrl()
    {
        return Yii::t('blog', 'http://yupe.ru');
    }

    public function getParamsLabels()
    {
        return array(
            'adminMenuOrder' => Yii::t('vote', 'Порядок следования в меню'),
        );
    }

    public function getIcon()
    {
        return "signal";
    }

    public function init()
    {
        parent::init();

        $this->setImport(array(
            'vote.models.*',
            'vote.components.*',
        ));
    }
}