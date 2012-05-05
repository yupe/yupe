<?php
class SocialModule extends YWebModule
{
    public $twitterKey;

    public $twitterSecret;

    public $facebookClientId;

    public $facebookClientSecret;

    public $vkontakteClientId;

    public $vkontakteClientSecret;

    public $mailruClientId;

    public $mailruClientSecret;

    public function getEditableParams()
    {
        return array(
            'twitterKey',
            'twitterSecret',
            'facebookClientId',
            'facebookClientSecret',
            'vkontakteClientId',
            'vkontakteClientSecret',
            'mailruClientId',
            'mailruClientSecret'
        );
    }

    public function getParamsLabels()
    {
        return array(
            'vkontakteClientId' => Yii::t('social','Вконтакте. ID приложения'),
            'vkontakteClientSecret' => Yii::t('social','Вконтакте. Защищенный ключ')
        );
    }

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
        return Yii::t('social', 'yupe team');
    }

    public function getAuthorEmail()
    {
        return Yii::t('social', 'team@yupe.ru');
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