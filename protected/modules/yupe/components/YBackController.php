<?php
class YBackController extends Controller
{
    public $menu = array();

    public $breadcrumbs = array();

    public function filters()
    {
        return array(
            array('application.modules.user.filters.YBackAccessControl')
        );
    }

    public function init()
    {
        $module = Yii::app()->getModule('yupe');
        $this->layout = $module->backendLayout;
        $jqueryslidemenupath = Yii::app()->assetManager->publish($module->basePath . '/web/jqueryslidemenu/');
        $chosen = Yii::app()->assetManager->publish($module->basePath . '/web/harvesthq/chosen/');
        Yii::app()->clientScript->registerCssFile($chosen . '/chosen.css');
        Yii::app()->clientScript->registerScriptFile($chosen . '/chosen.jquery.min.js');
        Yii::app()->clientScript->registerCssFile($jqueryslidemenupath . '/jqueryslidemenu.css');
        Yii::app()->clientScript->registerCoreScript('jquery');
        Yii::app()->clientScript->registerCoreScript('jquery.ui');
        Yii::app()->clientScript->registerCssFile(
            Yii::app()->clientScript->getCoreScriptUrl() .
            '/jui/css/base/jquery-ui.css'
        );
        Yii::app()->clientScript->registerScriptFile($jqueryslidemenupath . '/jqueryslidemenu.js');
        $this->setPageTitle(Yii::t('yupe', 'Панель управления'));
    }
}

?>

