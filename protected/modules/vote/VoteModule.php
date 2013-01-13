<?php

class VoteModule extends YWebModule
{

    public function getDependencies()
    {
        return array(
            'user',
        );
    }
    public function getName()
    {
        return Yii::t('VoteModule.vote', 'Голосование');
    }

    public function getCategory()
    {
        return Yii::t('VoteModule.vote', 'Сервисы');
    }

    public function getDescription()
    {
        return Yii::t('VoteModule.vote', 'Голосование за любой контент');
    }

    public function getNavigation()
    {
        return array(
            array('icon' => 'list-alt', 'label' => Yii::t('VoteModule.vote', 'Управление голосами'), 'url' => array('/vote/default/index')),
            array('icon' => 'plus-sign', 'label' => Yii::t('VoteModule.vote', 'Добавить голос'), 'url' => array('/vote/default/create')),
        );
    }

    public  function getVersion()
    {
        return Yii::t('VoteModule.vote', '0.1');
    }

    public function getAuthor()
    {
        return Yii::t('VoteModule.vote', 'yupe team');
    }

    public function getAuthorEmail()
    {
        return Yii::t('VoteModule.vote', 'team@yupe.ru');
    }

    public function getUrl()
    {
        return Yii::t('blog', 'http://yupe.ru');
    }

    public function getParamsLabels()
    {
        return array(
            'adminMenuOrder' => Yii::t('VoteModule.vote', 'Порядок следования в меню'),
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