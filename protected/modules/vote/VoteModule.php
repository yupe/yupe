<?php

class VoteModule extends YWebModule
{
    public function getName()
    {
        return Yii::t('vote', 'Голосование');
    }

    public function getDescription()
    {
        return Yii::t('vote', 'Голосование за любой контент');
    }

    public function getAuthor()
    {
        return Yii::t('vote', 'yupe team');
    }

    public function getAuthorEmail()
    {
        return Yii::t('feedback', 'team@yupe.ru');
    }

    public function getParamsLabels()
    {
        return array(
            'adminMenuOrder' => Yii::t('vote', 'Порядок следования в меню')
        );
    }

    public function getCategory()
    {
        return Yii::t('vote', 'Сервисы');
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