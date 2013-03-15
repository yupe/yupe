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

    public function getDependencies()
    {
        return array(
            'user',
        );
    }

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
            'mailruClientSecret',
            );
    }

    public function getParamsLabels()
    {
        return array(
            'vkontakteClientId'     => Yii::t('SocialModule.social', 'Вконтакте. ID приложения'),
            'vkontakteClientSecret' => Yii::t('SocialModule.social', 'Вконтакте. Защищенный ключ'),
        );
    }

    public function getCategory()
    {
        return Yii::t('SocialModule.social', 'Сервисы');
    }

    public function getName()
    {
        return Yii::t('SocialModule.social', 'Социализация');
    }

    public function getDescription()
    {
        return Yii::t('SocialModule.social', 'Модуль содержит компоненты и виджеты для взаимодействия с социальными сетями');
    }

    public function getAuthor()
    {
        return Yii::t('SocialModule.social', 'yupe team');
    }

    public function getAuthorEmail()
    {
        return Yii::t('SocialModule.social', 'team@yupe.ru');
    }

    public function getVersion()
    {
        return Yii::t('SocialModule.social', '0.1');
    }

    public function getUrl()
    {
        return Yii::t('SocialModule.social', 'http://yupe.ru');
    }

    public function getAdminPageLink()
    {
        return '/social/default/index';
    }

    public function getIcon()
    {
        return "globe";
    }
}