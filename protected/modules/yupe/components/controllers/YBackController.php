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

        $this->layout = $this->yupe->backendLayoutAlias;
        $backendTheme = $this->yupe->backendTheme;
        $this->setPageTitle(Yii::t('YupeModule.yupe', 'Панель управления Юпи!'));

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
                'class' => 'application.modules.yupe.extensions.booster.components.Bootstrap',
                'forceCopyAssets' => false
            ) + $assets));

            if (!$this->yupe->enableAssets)
                return;

            Yii::app()->preload[] = 'bootstrap';
        }
    }
    
    public function actionMultiaction()
    {
        if(!Yii::app()->request->isAjaxRequest || !Yii::app()->request->isPostRequest){
            throw new CHttpException(404);
        }
        
        $model  = Yii::app()->request->getPost('model');
        $action = Yii::app()->request->getPost('do');
        
        if(!isset($model,$action)){
            throw new CHttpException(404);
        }
        
        $items = Yii::app()->request->getPost('items');
        
        if(!is_array($items) || empty($items)){
            Yii::app()->ajax->success();
        }
            
        $transaction = Yii::app()->db->beginTransaction();
        
        try
        {
            switch ($action) {
                case self::BULK_DELETE:
                    $class = CActiveRecord::model($model);
                    $criteria = new CDbCriteria;
                    $items = array_filter($items,'intval');
                    $criteria->addInCondition('id',$items);
                    $count = $class->deleteAll($criteria);            
                    $transaction->commit();    
                    Yii::app()->ajax->success(Yii::t('YupeModule.yupe','Удалено {count} записей!',array(
                        '{count}' => $count
                    )));
                    break;
                
                default:
                    throw new CHttpException(404);                    
                    break;
            }
            
        }
        catch(Exception $e)
        {
            $transaction->rollback();
            Yii::log($e->__toString(),CLogger::LEVEL_ERROR);
            Yii::app()->ajax->failure($e->getMessage());
        }
    }

    public function actionActivate()
    {
        $status      = (int) Yii::app()->request->getQuery('status');
        $id          = (int) Yii::app()->request->getQuery('id');
        $modelClass  =       Yii::app()->request->getQuery('model');
        $statusField =       Yii::app()->request->getQuery('statusField');

        if (!isset($modelClass, $id, $status, $statusField))
            throw new CHttpException(404, Yii::t('YupeModule.yupe', 'Страница не найдена!'));

        $model = new $modelClass;
        $model = $model->resetScope()->findByPk($id);
        if (!$model)
            throw new CHttpException(404, Yii::t('YupeModule.yupe', 'Страница не найдена!'));

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
            throw new CHttpException(404, Yii::t('YupeModule.yupe', 'Страница не найдена!'));

        $model         = new $modelClass;
        $model_depends = new $modelClass;
        $model         = $model->resetScope()->findByPk($id);
        if (!$model)
            throw new CHttpException(404, Yii::t('YupeModule.yupe', 'Страница не найдена!'));

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
