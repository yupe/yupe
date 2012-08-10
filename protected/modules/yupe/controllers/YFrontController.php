<?php

class YFrontController extends YMainController
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
        parent::init();

        $this->pageTitle   = $this->yupe->siteName;
        $this->description = $this->yupe->siteDescription;
        $this->keywords    = $this->yupe->siteKeyWords;

        $baseUrl = Yii::app()->baseUrl;
        $fileUrl = Yii::app()->theme->basePath . "/" . ucwords(Yii::app()->theme->name) . "Theme.php";

        if ( Yii::app()->theme && is_file($fileUrl))
            require($fileUrl);

        Yii::app()->clientScript->registerScript('yupe_base_url', "var baseUrl = '$baseUrl';", CClientScript::POS_HEAD);
    }
}