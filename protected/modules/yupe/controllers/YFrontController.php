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
        $this->pageTitle = Yii::app()->getModule('yupe')->siteName;
        $this->description = Yii::app()->getModule('yupe')->siteDescription;
        $this->keywords = Yii::app()->getModule('yupe')->siteKeyWords;

        $baseUrl = Yii::app()->baseUrl;

        Yii::app()->clientScript->registerScript('yupe_base_url', "var baseUrl = '$baseUrl';", CClientScript::POS_HEAD);
    }
}

?>