<?php

class YBackController extends YMainController
{
    const BULK_DELETE = 'delete';

    public function filters()
    {
        return array(
            array('application.modules.yupe.filters.YBackAccessControl'),
        );
    }

    public function init()
    {
        parent::init();
        //$this->yupe->getComponent('bootstrap');
        $this->layout = $this->yupe->getBackendLayoutAlias();
        $backendTheme = $this->yupe->backendTheme;
        $this->setPageTitle(Yii::t('YupeModule.yupe', 'Панель управления Юпи!'));

        if ($backendTheme && is_dir(Yii::getPathOfAlias("webroot.themes.backend_" . $backendTheme))) {
            Yii::app()->theme = "backend_" . $backendTheme;
        } else {
            Yii::app()->theme = null;
            if (!$this->yupe->enableAssets)
                return;
        }
    }

    protected function beforeAction($action)
    {
        /**
         * $this->module->getId() !== 'install' избавляет от ошибок на этапе установки
         * $this->id !== 'backend' || ($this->id == 'backend' && $action->id != 'modupdate') устраняем проблемы с зацикливанием
         */
        if ($this->module->getId() !== 'install'
            && ($this->id !== 'backend' || ($this->id == 'backend' && $action->id != 'modupdate'))
            && ($updates = Yii::app()->migrator->checkForUpdates(array($this->module->getId() => $this->module))) !== null
            && count($updates) > 0
        ) {
            Yii::app()->user->setFlash(
                YFlashMessages::WARNING_MESSAGE,
                Yii::t('YupeModule.yupe', 'Перед тем как начать работать с модулем, необходимо установить все необходимые миграции.')
            );

            $this->redirect(array('/yupe/backend/modupdate', 'name' => $this->module->getId()));
        }

        return parent::beforeAction($action);
    }

    public function actionMultiaction()
    {
        if (!Yii::app()->request->isAjaxRequest || !Yii::app()->request->isPostRequest) {
            throw new CHttpException(404);
        }

        $model = Yii::app()->request->getPost('model');
        $action = Yii::app()->request->getPost('do');

        if (!isset($model, $action)) {
            throw new CHttpException(404);
        }

        $items = Yii::app()->request->getPost('items');

        if (!is_array($items) || empty($items)) {
            Yii::app()->ajax->success();
        }

        $transaction = Yii::app()->db->beginTransaction();

        try {
            switch ($action) {
            case self::BULK_DELETE:
                $class = CActiveRecord::model($model);
                $criteria = new CDbCriteria;
                $items = array_filter($items, 'intval');
                $criteria->addInCondition('id', $items);
                $count = $class->deleteAll($criteria);
                $transaction->commit();
                Yii::app()->ajax->success(
                    Yii::t(
                        'YupeModule.yupe', 'Удалено {count} записей!', array(
                            '{count}' => $count
                        )
                    )
                );
                break;

            default:
                throw new CHttpException(404);
                break;
            }

        } catch (Exception $e) {
            $transaction->rollback();
            Yii::log($e->__toString(), CLogger::LEVEL_ERROR);
            Yii::app()->ajax->failure($e->getMessage());
        }
    }

    public function actionActivate()
    {
        $status = (int)Yii::app()->request->getQuery('status');
        $id = (int)Yii::app()->request->getQuery('id');
        $modelClass = Yii::app()->request->getQuery('model');
        $statusField = Yii::app()->request->getQuery('statusField');

        if (!isset($modelClass, $id, $status, $statusField))
            throw new CHttpException(404, Yii::t('YupeModule.yupe', 'Страница не найдена!'));

        $model = new $modelClass;
        $model = $model->resetScope()->findByPk($id);
        if (!$model)
            throw new CHttpException(404, Yii::t('YupeModule.yupe', 'Страница не найдена!'));

        $model->$statusField = $status;
        $model->update(array($statusField));

        if (!Yii::app()->request->isAjaxRequest)
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
    }

    public function actionSort()
    {
        $id = (int)Yii::app()->request->getQuery('id');
        $direction = Yii::app()->request->getQuery('direction');
        $modelClass = Yii::app()->request->getQuery('model');
        $sortField = Yii::app()->request->getQuery('sortField');

        if (!isset($direction, $id, $modelClass, $sortField))
            throw new CHttpException(404, Yii::t('YupeModule.yupe', 'Страница не найдена!'));

        $model = new $modelClass;
        $model_depends = new $modelClass;
        $model = $model->resetScope()->findByPk($id);
        if (!$model)
            throw new CHttpException(404, Yii::t('YupeModule.yupe', 'Страница не найдена!'));

        if ($direction === 'up') {
            $model_depends = $model_depends->findByAttributes(array($sortField => ($model->$sortField - 1)));
            $model_depends->$sortField++;
            $model->$sortField--; // example menu_order column in sql
        } else {
            $model_depends = $model_depends->findByAttributes(array($sortField => ($model->$sortField + 1)));
            $model_depends->$sortField--;
            $model->$sortField++;
        }

        $model->update(array($sortField));
        $model_depends->update(array($sortField));

        if (!Yii::app()->request->isAjaxRequest)
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
    }
}
