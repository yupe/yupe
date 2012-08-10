<?php

class YBackController extends YMainController
{
    public function filters()
    {
        return array(
            array( 'application.modules.yupe.filters.YBackAccessControl' )
        );
    }

    public function init()
    {
        parent::init();

        $this->layout = $this->yupe->backendLayoutAlias;

        if ($this->yupe->backendTheme && is_dir(Yii::getPathOfAlias("webroot.themes.backend_" . $this->yupe->backendTheme)))
        {
            $themeBase = "webroot.themes.backend_" . $this->yupe->backendTheme;
            Yii::app()->theme = "backend_" . $this->yupe->backendTheme;
            $themeFile = Yii::app()->theme->basePath . "/" . ucwords($this->yupe->backendTheme) . "Theme.php";

            if (is_file($themeFile))
                require($themeFile);
        }
        else
        {
            Yii::app()->theme = 'default';
            $this->layout = 'application.modules.yupe.views.layouts.column2';
        }


        Yii::app()->clientScript->registerCoreScript('jquery');
        Yii::app()->clientScript->registerCoreScript('jquery.ui');
        Yii::app()->clientScript->registerCssFile(
            Yii::app()->clientScript->getCoreScriptUrl() . '/jui/css/base/jquery-ui.css'
        );

        $this->setPageTitle(Yii::t('yupe', 'Панель управления'));
    }

    public function actionActivate()
    {
        $status      = (int) Yii::app()->request->getQuery('status');
        $id          = (int) Yii::app()->request->getQuery('id');
        $modelClass  = Yii::app()->request->getQuery('model');
        $statusField = Yii::app()->request->getQuery('statusField');

        if (!isset($modelClass, $id, $status, $statusField))
            throw new CHttpException(404, Yii::t('yupe', 'Страница не найдена!'));

        $model = new $modelClass;
        $model = $model->resetScope()->findByPk($id);
        if (!$model)
            throw new CHttpException(404, Yii::t('yupe', 'Страница не найдена!'));

        $model->$statusField = $status;
        $model->update(array( $statusField ));

        if (!Yii::app()->request->isAjaxRequest)
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array( 'admin' ));
    }

    public function actionSort()
    {
        $direction  = Yii::app()->request->getQuery('direction');
        $id         = (int) Yii::app()->request->getQuery('id');
        $modelClass = Yii::app()->request->getQuery('model');
        $sortField  = Yii::app()->request->getQuery('sortField');

        if (!isset($direction, $id, $modelClass, $sortField))
            throw new CHttpException(404, Yii::t('yupe', 'Страница не найдена!'));

        $model         = new $modelClass;
        $model_depends = new $modelClass;
        $model         = $model->resetScope()->findByPk($id);
        if (!$model)
            throw new CHttpException(404, Yii::t('yupe', 'Страница не найдена!'));

        if ($direction === 'up')
        {
            $model_depends = $model_depends->findByAttributes(array( $sortField => ($model->$sortField - 1) ));
            $model_depends->$sortField++;
            $model->$sortField--; #example menu_order column in sql
        }
        else
        {
            $model_depends = $model_depends->findByAttributes(array( $sortField => ($model->$sortField + 1) ));
            $model_depends->$sortField--;
            $model->$sortField++;
        }

        $model->update(array( $sortField ));
        $model_depends->update(array( $sortField ));

        if (!Yii::app()->request->isAjaxRequest)
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array( 'admin' ));
    }
}