<?php
class NewsModule extends YWebModule
{
    public function getParamsLabels()
    {
        return array(
            'adminMenuOrder' => Yii::t('news', 'Порядок следования в меню')
        );
    }

    public function getCategory()
    {
        return Yii::t('news', 'Контент');
    }
    
    public function getName()
    {
        return Yii::t('news', 'Новости');
    }

    public function getDescription()
    {
        return Yii::t('news', 'Модуль для создания и публикации новостей');
    }

    public function getAuthor()
    {
        return Yii::t('news', 'xoma');
    }

    public function getAuthorEmail()
    {
        return Yii::t('news', 'aopeykin@yandex.ru');
    }

    public function getUrl()
    {
        return Yii::t('news', 'http://yupe.ru');
    }

    public function init()
    {
        parent::init();

        $this->setImport(array(
                              'news.models.*',
                              'news.components.*',
                         ));
    }
}
