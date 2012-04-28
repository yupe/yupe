<?php
class YBackController extends Controller
{
    public $menu = array();

    public $breadcrumbs = array();

    public $actions = array('activate','deactivate');

    public function filters()
    {
        return array(
            array('application.modules.yupe.filters.YBackAccessControl')
        );
    }

    public function init()
    {
        $module = Yii::app()->getModule('yupe');
        $this->layout = $module->backendLayoutAlias;
        if ( $module->backendTheme )
        {
            $themeBase = "webroot.themes.backend_".$module->backendTheme;
            Yii::app()->theme= "backend_".$module->backendTheme;

            if ( is_file( Yii::app()->theme->basePath."/".ucwords($module->backendTheme)."Theme.php") )
                require(Yii::app()->theme->basePath."/".ucwords($module->backendTheme)."Theme.php");
        }
        Yii::app()->clientScript->registerCoreScript('jquery');
        Yii::app()->clientScript->registerCoreScript('jquery.ui');
        Yii::app()->clientScript->registerCssFile(
            Yii::app()->clientScript->getCoreScriptUrl() .
            '/jui/css/base/jquery-ui.css'
        );
        $this->setPageTitle(Yii::t('yupe', 'Панель управления'));
    }

    public function actionActivate()
    {
        $status = (int)Yii::app()->request->getQuery('status');
        $id     = (int)Yii::app()->request->getQuery('id');
        $modelClass   = Yii::app()->request->getQuery('model');
        $statusField  = Yii::app()->request->getQuery('statusField');

        if(!isset($modelClass,$id,$status,$statusField))
            throw new CHttpException(404,Yii::t('yupe','Страница не найдена!'));

        $model = new $modelClass;
        $model = $model->resetScope()->findByPk($id);
        if(!$model)
            throw new CHttpException(404,Yii::t('yupe','Страница не найдена!'));

        $model->$statusField = $status;
        $model->update(array($statusField));

        if(!Yii::app()->request->isAjaxRequest){
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
    }
}