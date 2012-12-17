<?php

class JquerySlideMenuWidget extends CWidget
{

    public function init()
    {
        parent::init();
        $this->publishAssets();
    }

    public function run()
    {
        //
    }

    public function publishAssets()
    {
        $assets  = dirname(__FILE__) . '/jqueryslidemenu';
        $baseUrl = Yii::app()->assetManager->publish($assets);

        if (is_dir($assets))
        {
            $js = "var arrowimages = {down:['downarrowclass', '{$baseUrl}/down.gif', 23], right:['rightarrowclass', '{$baseUrl}/right.gif']}";
            Yii::app()->clientScript->registerScript(__CLASS__ . '#jqueryslidemenu', $js, CClientScript::POS_BEGIN);
            Yii::app()->clientScript->registerCoreScript('jquery');
            Yii::app()->clientScript->registerScriptFile($baseUrl . '/jqueryslidemenu.js', CClientScript::POS_END);
            Yii::app()->clientScript->registerCssFile($baseUrl . '/jqueryslidemenu.css');
        }
        else
            throw new CHttpException(500, 'Error: Assest dir no create!');
    }
}