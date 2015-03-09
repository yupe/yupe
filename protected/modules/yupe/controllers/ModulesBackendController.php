<?php

/**
 * Class ModuleBackendController
 * @since 0.8
 */
class ModulesBackendController extends yupe\components\controllers\BackController
{
    public function accessRules()
    {
        return [
            ['allow', 'roles' => ['admin']],
            ['deny',],
        ];
    }

    /**
     *
     */
    public function actionConfigUpdate()
    {
        if (!Yii::app()->getRequest()->getIsPostRequest()) {
            throw new CHttpException(404);
        }

        $module = Yii::app()->getRequest()->getPost('module');

        if (empty($module) || !Yii::app()->hasModule($module)) {
            throw new CHttpException(404);
        }

        if (Yii::app()->moduleManager->updateModuleConfig(Yii::app()->getModule($module))) {
            Yii::app()->ajax->success();
        }

        Yii::app()->ajax->failure();
    }

    /**
     * Действие для управления модулями:
     *
     * @throws CHttpException
     *
     * @return string json-data
     **/
    public function actionModuleStatus()
    {
        if (!Yii::app()->getRequest()->getIsPostRequest() || !Yii::app()->getRequest()->getIsAjaxRequest()) {
            throw new CHttpException(404, Yii::t('YupeModule.yupe', 'Page was not found!'));
        }

        /**
         * Получаем название модуля и проверяем,
         * возможно модуль необходимо подгрузить
         **/
        if (($name = Yii::app()->getRequest()->getPost('module'))
            && ($status = Yii::app()->getRequest()->getPost('status')) !== null
            && (($module = Yii::app()->getModule($name)) === null || $module->canActivate())
        ) {
            $module = Yii::app()->moduleManager->getCreateModule($name);
        } /**
         * Если статус неизвестен - ошибка:
         **/
        elseif (!isset($status) || !in_array($status, [0, 1, 2])) {
            Yii::app()->ajax->failure(Yii::t('YupeModule.yupe', 'Status for handler is no set!'));
        }

        /**
         * Если всё в порядке - выполняем нужное действие:
         **/
        if (isset($module) && !empty($module)) {
            $result = false;
            try {
                switch ($status) {
                    case 0:
                        if ($module->getIsActive()) {
                            $module->getDeActivate();
                            $message = Yii::t('YupeModule.yupe', 'Module disabled successfully!');
                        } else {
                            $module->getUnInstall();
                            $message = Yii::t('YupeModule.yupe', 'Module uninstalled successfully!');
                        }
                        $result = true;
                        break;

                    case 1:

                        if ($module->getIsInstalled()) {
                            $module->getActivate();
                            $message = Yii::t('YupeModule.yupe', 'Module enabled successfully!');
                        } else {
                            $module->getInstall();
                            $message = Yii::t('YupeModule.yupe', 'Module installed successfully!');
                        }
                        $result = true;
                        break;
                    case 2:
                        $message = ($result = Yii::app()->moduleManager->updateModuleConfig($module))
                            ? Yii::t('YupeModule.yupe', 'Settings file "{n}" updated successfully!', $name)
                            : Yii::t(
                                'YupeModule.yupe',
                                'There is en error when trying to update "{n}" file module!',
                                $name
                            );
                        Yii::app()->getUser()->setFlash(
                            $result ? yupe\widgets\YFlashMessages::SUCCESS_MESSAGE : yupe\widgets\YFlashMessages::ERROR_MESSAGE,
                            $message
                        );
                        break;
                    default:
                        $message = Yii::t('YupeModule.yupe', 'Unknown action was checked!');
                        break;
                }
                if (in_array($status, [0, 1, 2])) {
                    Yii::app()->getCache()->clear($name);
                }
            } catch (Exception $e) {
                $message = $e->getMessage();
            }

            /**
             * Возвращаем ответ:
             **/
            $result === true
                ? Yii::app()->ajax->success($message)
                : Yii::app()->ajax->failure($message);

        } else {
            /**
             * Иначе возвращаем ошибку:
             **/
            Yii::app()->ajax->failure(Yii::t('YupeModule.yupe', 'Module was not found or it\'s enabling finished'));
        }
    }

}
