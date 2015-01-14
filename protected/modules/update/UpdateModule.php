<?php

use yupe\components\WebModule;
use yupe\helpers\YFile;

class UpdateModule extends WebModule
{
    const VERSION = '0.9.1';

    public $controllerNamespace = '\application\modules\update\controllers';

    public  $updateTmpPath;

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
        return "fa fa-fw fa-refresh";
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
        return [
            ['label' => Yii::t('UpdateModule.update', 'Updates')],
            [
                'icon' => 'fa fa-fw fa-refresh',
                'label' => Yii::t('UpdateModule.update', 'Check for updates'),
                'url' => ['/update/updateBackend/index']
            ],
        ];
    }

    public function init()
    {
        parent::init();

        $this->setImport(
            [
                'update.models.*',
                'update.components.*',
            ]
        );

        $this->updateTmpPath = Yii::getPathOfAlias('application.runtime') . DIRECTORY_SEPARATOR . 'updates';
    }

    public function getInstall()
    {
        if (parent::getInstall()) {
            YFile::checkPath($this->updateTmpPath);
        }

        return false;
    }

    public function checkSelf()
    {
        $messages = [];

        if (!YFile::checkPath($this->updateTmpPath)) {
            $messages[WebModule::CHECK_ERROR][] = [
                'type' => WebModule::CHECK_ERROR,
                'message' => Yii::t(
                        'UpdateModule.update',
                        'Please, choose catalog for updates!'
                    ),
            ];
        }

        if (!YFile::checkPath(Yii::getPathOfAlias("application.modules"))) {
            $messages[WebModule::CHECK_ERROR][] = [
                'type' => WebModule::CHECK_ERROR,
                'message' => Yii::t(
                    'UpdateModule.update',
                    'Directory {dir} is not writable!',
                    ['{dir}' => Yii::getPathOfAlias("application.modules")]
                ),
            ];
        }


        return (isset($messages[WebModule::CHECK_ERROR])) ? $messages : true;
    }

    public function getAuthItems()
    {
        return [
            [
                'name'        => 'UpdateManage',
                'description' => Yii::t('UpdateModule.update', 'Modules update'),
                'type'        => 1,
                'items'       => [
                    [
                        'type'        => 0,
                        'name'        => 'Update.UpdateBackend.index',
                        'description' => Yii::t('UpdateModule.update', 'Modules update view')
                    ],
                    [
                        'type'        => 0,
                        'name'        => 'Update.UpdateBackend.update',
                        'description' => Yii::t('UpdateModule.update', 'Modules update')
                    ],
                ]
            ]
        ];
    }
}
