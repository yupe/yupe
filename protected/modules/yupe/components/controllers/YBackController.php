<?php

class YBackController extends YMainController
{
    public function filters()
    {
        return array(
            array('application.modules.yupe.filters.YBackAccessControl'),
        );
    }

    public function init()
    {
        parent::init();

        $this->layout = $this->yupe->backendLayoutAlias;
        $backendTheme = $this->yupe->backendTheme;
        $this->setPageTitle(Yii::t('yupe', 'Панель управления'));

        if ($backendTheme && is_dir(Yii::getPathOfAlias("webroot.themes.backend_" . $backendTheme))) {
          //$themeBase        = "webroot.themes.backend_" . $backendTheme;
            Yii::app()->theme = "backend_" . $backendTheme;
            $themeFile        = Yii::app()->theme->basePath . "/" . ucwords($backendTheme) . "Theme.php";

            if (is_file($themeFile))
                require($themeFile);
        } else {
            $assets = ($this->yupe->enableAssets) ? array() : array(
                'coreCss'       => false,
                'responsiveCss' => false,
                'yiiCss'        => false,
                'jqueryCss'     => false,
                'enableJS'      => false,
            );

            Yii::app()->theme = null;
            Yii::app()->setComponent('bootstrap', Yii::createComponent(array(
                'class'                    => 'application.modules.yupe.extensions.booster.components.Bootstrap',
                'republishAssetsOnRequest' => false,
            ) + $assets));

            if (!$this->yupe->enableAssets)
                return;

            Yii::app()->preload[] = 'bootstrap';
        }

        Yii::app()->clientScript->registerCoreScript('jquery');
        // @TODO необходимо избавиться от эллементво использующих jquery ui и yupeAdmin.js
        Yii::app()->clientScript->registerCoreScript('jquery.ui');
        Yii::app()->clientScript->registerCssFile(Yii::app()->clientScript->getCoreScriptUrl() . '/jui/css/base/jquery-ui.css');
        $webPath = Yii::app()->assetManager->publish($this->yupe->basePath . '/web/');
        Yii::app()->clientScript->registerScriptFile($webPath . '/yupeAdmin.js');
    }

    public function actionActivate()
    {
        $status      = (int) Yii::app()->request->getQuery('status');
        $id          = (int) Yii::app()->request->getQuery('id');
        $modelClass  =       Yii::app()->request->getQuery('model');
        $statusField =       Yii::app()->request->getQuery('statusField');

        if (!isset($modelClass, $id, $status, $statusField))
            throw new CHttpException(404, Yii::t('yupe', 'Страница не найдена!'));

        $model = new $modelClass;
        $model = $model->resetScope()->findByPk($id);
        if (!$model)
            throw new CHttpException(404, Yii::t('yupe', 'Страница не найдена!'));

        $model->$statusField = $status;
        $model->update(array($statusField));

        if (!Yii::app()->request->isAjaxRequest)
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array( 'admin' ));
    }

    public function actionSort()
    {
        $id         = (int) Yii::app()->request->getQuery('id');
        $direction  =       Yii::app()->request->getQuery('direction');
        $modelClass =       Yii::app()->request->getQuery('model');
        $sortField  =       Yii::app()->request->getQuery('sortField');

        if (!isset($direction, $id, $modelClass, $sortField))
            throw new CHttpException(404, Yii::t('yupe', 'Страница не найдена!'));

        $model         = new $modelClass;
        $model_depends = new $modelClass;
        $model         = $model->resetScope()->findByPk($id);
        if (!$model)
            throw new CHttpException(404, Yii::t('yupe', 'Страница не найдена!'));

        if ($direction === 'up') {
            $model_depends = $model_depends->findByAttributes(array($sortField => ($model->$sortField - 1)));
            $model_depends->$sortField++;
            $model->$sortField--; #example menu_order column in sql
        } else {
            $model_depends = $model_depends->findByAttributes(array($sortField => ($model->$sortField + 1)));
            $model_depends->$sortField--;
            $model->$sortField++;
        }

        $model->update(array($sortField));
        $model_depends->update(array($sortField));

        if (!Yii::app()->request->isAjaxRequest)
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }
}