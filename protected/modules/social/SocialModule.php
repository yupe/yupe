<?php
use yupe\components\WebModule;

class SocialModule extends WebModule
{
    const VERSION = '0.2';

    public $controllerNamespace = '\application\modules\social\controllers';

    public function getDependencies()
    {
        return array(
            'user',
        );
    }

    public function getEditableParams()
    {
        return array();
    }

    public function getParamsLabels()
    {
        return array();
    }

    public function getCategory()
    {
        return Yii::t('SocialModule.social', 'Users');
    }

    public function getName()
    {
        return Yii::t('SocialModule.social', 'Socialization');
    }

    public function getDescription()
    {
        return Yii::t('SocialModule.social', 'Module for login and registration via social networks');
    }

    public function getAuthor()
    {
        return Yii::t('SocialModule.social', 'amyLabs');
    }

    public function getAuthorEmail()
    {
        return Yii::t('SocialModule.social', 'hello@amylabs.ru');
    }

    public function getVersion()
    {
        return Yii::t('SocialModule.social', self::VERSION);
    }

    public function getUrl()
    {
        return Yii::t('SocialModule.social', 'http://amylabs.ru');
    }

    public function getAdminPageLink()
    {
        return '/social/default/index';
    }

    public function getIcon()
    {
        return "globe";
    }

    public function init()
    {
        parent::init();
    }

	public function getIsInstallDefault()
	{
		return true;
	}
}