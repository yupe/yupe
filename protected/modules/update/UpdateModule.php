<?php

use yupe\components\WebModule;
use yupe\helpers\YFile;

/**
 * Class UpdateModule
 */
class UpdateModule extends WebModule
{
    /**
     *
     */
    const VERSION = '0.9.9';

    /**
     * @var string
     */
    public $controllerNamespace = '\application\modules\update\controllers';

    /**
     * @var
     */
    public $updateTmpPath;

    /**
     * @return string
     */
    public function getCategory()
    {
        return Yii::t('UpdateModule.update', 'Yupe!');
    }

    /**
     * @return string
     */
    public function getName()
    {
        return Yii::t('UpdateModule.update', 'Updates');
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return Yii::t('UpdateModule.update', 'Update and notification system for Yupe!');
    }

    /**
     * @return string
     */
    public function getAuthor()
    {
        return Yii::t('UpdateModule.update', 'amylabs team');
    }

    /**
     * @return string
     */
    public function getAuthorEmail()
    {
        return Yii::t('UpdateModule.update', 'hello@amylabs.ru');
    }

    /**
     * @return string
     */
    public function getIcon()
    {
        return "fa fa-fw fa-refresh";
    }

    /**
     * @return string
     */
    public function getVersion()
    {
        return self::VERSION;
    }

    /**
     * @return string
     */
    public function getAdminPageLink()
    {
        return '/update/updateBackend/index';
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return 'http://amylabs.ru';
    }

    /**
     * @return array
     */
    public function getNavigation()
    {
        return [
            ['label' => Yii::t('UpdateModule.update', 'Updates')],
            [
                'icon' => 'fa fa-fw fa-refresh',
                'label' => Yii::t('UpdateModule.update', 'Check for updates'),
                'url' => ['/update/updateBackend/index'],
            ],
        ];
    }

    /**
     *
     */
    public function init()
    {
        parent::init();

        $this->setImport(
            [
                'update.models.*',
                'update.components.*',
            ]
        );

        $this->updateTmpPath = Yii::getPathOfAlias('application.runtime').DIRECTORY_SEPARATOR.'updates';
    }

    /**
     * @return bool
     */
    public function getInstall()
    {
        if (parent::getInstall()) {
            YFile::checkPath($this->updateTmpPath);
        }

        return false;
    }

    /**
     * @return array|bool
     */
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

    /**
     * @return array
     */
    public function getAuthItems()
    {
        return [
            [
                'name' => 'UpdateManage',
                'description' => Yii::t('UpdateModule.update', 'Modules update'),
                'type' => 1,
                'items' => [
                    [
                        'type' => 0,
                        'name' => 'Update.UpdateBackend.index',
                        'description' => Yii::t('UpdateModule.update', 'Modules update view'),
                    ],
                    [
                        'type' => 0,
                        'name' => 'Update.UpdateBackend.update',
                        'description' => Yii::t('UpdateModule.update', 'Modules update'),
                    ],
                ],
            ],
        ];
    }
}
