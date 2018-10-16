<?php

namespace application\modules\update\controllers;

use Yii;
use yupe\components\controllers\BackController;
use yupe\widgets\YFlashMessages;

class UpdateBackendController extends BackController
{
    public function accessRules()
    {
        return [
            ['allow', 'roles' => ['admin']],
            ['allow', 'actions' => ['index'], 'roles' => ['Update.UpdateBackend.index']],
            ['allow', 'actions' => ['update'], 'roles' => ['Update.UpdateBackend.update']],
            ['deny']
        ];
    }

    public function actionIndex()
    {
        $modules = Yii::app()->moduleManager->getModules();

        $updates = Yii::app()->updateManager->getModulesUpdateInfo(
            $modules['modules']
        );

        $this->render('index', [
                'success' => is_array($updates),
                'updates' => $updates,
                'modules' => $modules['modules']
            ]);
    }

    public function actionUpdate()
    {
        if(!Yii::app()->getRequest()->getIsPostRequest()){
            throw new \CHttpException(404);
        }

        $module = Yii::app()->getRequest()->getPost('module');

        $version = Yii::app()->getRequest()->getPost('version');

        if(empty($module) || empty($version)) {
            throw new \CHttpException(404);
        }

        if(Yii::app()->updateManager->getModuleRemoteFile($module, $version)) {
            // установка новой версии модуля
            if(Yii::app()->updateManager->update($module, $version)) {
                Yii::app()->getUser()->setFlash(YFlashMessages::SUCCESS_MESSAGE, Yii::t('UpdateModule.update', 'Module updated!'));
                Yii::app()->ajax->success();
            }
        }

        Yii::app()->ajax->failure();
    }
} 
