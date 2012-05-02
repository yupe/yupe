<?php
class ContestModule extends YWebModule
{
    public function getName()
    {
        return Yii::t('contest', 'Конкурсы изображений');
    }

    public  function getVersion()
    {
        return '0.1 (dev)';
    }

    public function getDescription()
    {
        return Yii::t('contest', 'Модуль для простых конкурсов изображений');
    }

    public function getAuthor()
    {
        return Yii::t('contest', 'yupe team');
    }

    public function getAuthorEmail()
    {
        return Yii::t('feedback', 'team@yupe.ru');
    }

    public function getParamsLabels()
    {
        return array(
            'adminMenuOrder' => Yii::t('contest', 'Порядок следования в меню')
        );
    }

    public function getCategory()
    {
        return Yii::t('contest', 'Сервисы');
    }    

    public function init()
    {
        $this->setImport(array(
                              'contest.models.*',
                              'contest.components.*',
                         ));
    }
}