<?php
class SocialModule extends YWebModule
{	
	public function getCategory()
    {
        return Yii::t('social', 'Сервисы');
    }

    public function getName()
    {
        return Yii::t('social', 'Социализация');
    }

    public function getDescription()
    {
        return Yii::t('social', 'Модуль содержит компоненты и виджеты для взаимодействия с социальными сетями');
    }

    public function getAuthor()
    {
        return Yii::t('social', 'xoma');
    }

    public function getAuthorEmail()
    {
        return Yii::t('social', 'aopeykin@yandex.ru');
    }

    public function getUrl()
    {
        return Yii::t('social', 'http://yupe.ru');
    }

    public function getAdminPageLink()
    {
        return '/social/default/';
    }
}