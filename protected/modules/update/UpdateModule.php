<?php

class UpdateModule extends \yupe\components\WebModule
{
    const VERSION = '0.2';

    public $controllerNamespace = '\application\modules\update\controllers';

    public function getCategory()
    {
        return Yii::t('UpdateModule.update', 'Yupe!');
    }

    public function getName()
    {
        return Yii::t('UpdateModule.update', 'Updates');
    }

    public function getDescription()
    {
        return Yii::t('UpdateModule.update', 'Update and notification system for Yupe!');
    }

    public function getAuthor()
    {
        return Yii::t('UpdateModule.update', 'amylabs team');
    }

    public function getAuthorEmail()
    {
        return Yii::t('UpdateModule.update', 'hello@amylabs.ru');
    }

    public function getIcon()
    {
        return "glyphicon glyphicon-refresh";
    }

    public function getVersion()
    {
        return self::VERSION;
    }

    public function getAdminPageLink()
    {
        return '/update/updateBackend/index';
    }

    public function getUrl()
    {
        return 'http://amylabs.ru';
    }

    public function getNavigation()
    {
        return array(
            array('label' => Yii::t('UpdateModule.update', 'Updates')),
            array(
                'icon' => 'glyphicon glyphicon-refresh',
                'label' => Yii::t('UpdateModule.update', 'Check for updates'),
                'url' => array('/update/updateBackend/index')
            ),
        );
    }

    public function init()
    {
        parent::init();

        $this->setImport(
            array(
                'update.models.*',
                'update.components.*',
            )
        );
    }

}
