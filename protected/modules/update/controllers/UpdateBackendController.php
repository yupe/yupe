<?php

namespace application\modules\update\controllers;

use Yii;
use yupe\components\controllers\BackController;
use yupe\widgets\YFlashMessages;

class UpdateBackendController extends BackController
{
    public function accessRules()
    {
        return array(
            array('allow', 'roles' => array('admin')),
            array('allow', 'actions' => array('index'), 'roles' => array('Update.UpdateBackend.index')),
            array('allow', 'actions' => array('update'), 'roles' => array('Update.UpdateBackend.update')),
            array('deny')
        );
    }

    public function actionIndex()
    {
        if (Yii::app()->getRequest()->getIsPostRequest()) {

            $modules = Yii::app()->moduleManager->getModules();

            $updates = Yii::app()->updateManager->getModulesUpdateList(
                $modules['modules']
            );

            $success = is_array($updates);

            Yii::app()->ajax->success(
                $this->renderPartial(
                    '_modules',
                    array(
                        'success' => $success,
                        'updates' => $updates,
                        'modules' => $modules['modules']
                    ),
                    true
                )
            );
        }

        $this->render('index');
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
