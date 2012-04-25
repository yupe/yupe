<?php
class YBackController extends Controller
{
    public $menu = array();

    public $breadcrumbs = array();

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
}