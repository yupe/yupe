<?php

class YFrontController extends CController
{

    public $menu = array();
    public $breadcrumbs = array();
    public $description;
    public $keywords;

    public function setpageTitle($title)
    {
        $this->pageTitle = $this->pageTitle . ' | ' . $title;
    }

    public function init()
    {
        $module = Yii::app()->getModule('yupe');
        $this->pageTitle   = $module->siteName;
        $this->description = $module->siteDescription;
        $this->keywords    = $module->siteKeyWords;
        $baseUrl = Yii::app()->baseUrl;
        if ( Yii::app()->theme )
            if ( is_file( Yii::app()->theme->basePath."/".ucwords(Yii::app()->theme->name)."Theme.php") )
                require(Yii::app()->theme->basePath."/".ucwords(Yii::app()->theme->name)."Theme.php");

        Yii::app()->clientScript->registerScript('yupe_base_url', "var baseUrl = '$baseUrl';", CClientScript::POS_HEAD);
    }
}