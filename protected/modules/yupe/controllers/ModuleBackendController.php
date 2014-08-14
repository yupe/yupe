<?php

/**
 * Class ModuleBackendController
 * @since 0.8
 */
class ModuleBackendController extends yupe\components\controllers\BackController
{
    /**
     *
     */
    public function actionConfigUpdate()
    {
        if(!Yii::app()->getRequest()->getIsPostRequest()) {
            throw new CHttpException(404);
        }

        $module = Yii::app()->getRequest()->getPost('module');

        if(empty($module) || !Yii::app()->hasModule($module)) {
            throw new CHttpException(404);
        }

        if(Yii::app()->moduleManager->updateModuleConfig(Yii::app()->getModule($module))) {
            Yii::app()->ajax->success();
        }

        Yii::app()->ajax->failure();
    }
} 