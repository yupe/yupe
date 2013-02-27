<?php

class FancyBox extends CWidget
{

    public $id;
    public $target;
    public $easingEnabled=false;
    public $mouseEnabled=true;
    public $config=array();

    public function init()
    {
        if(!isset($this->id))
            $this->id=$this->getId();
        $this->publishAssets();
    }

    public function run()
    {
        $config = CJavaScript::encode($this->config);
        Yii::app()->clientScript->registerScript($this->getId(), "
			$('$this->target').fancybox($config);
		");
    }

    public function publishAssets()
    {
        $assets = dirname(__FILE__).'/vendor/fancybox';
        $baseUrl = Yii::app()->assetManager->publish($assets);
        if(is_dir($assets))
        {
            Yii::app()->clientScript->registerCoreScript('jquery');
            Yii::app()->clientScript->registerScriptFile($baseUrl . '/source/jquery.fancybox.pack.js', CClientScript::POS_HEAD);
            Yii::app()->clientScript->registerScriptFile($baseUrl . '/lib/jquery.isotope.min.js', CClientScript::POS_HEAD);
            Yii::app()->clientScript->registerCssFile($baseUrl . '/source/jquery.fancybox.css');

            if ($this->mouseEnabled)
                Yii::app()->clientScript->registerScriptFile($baseUrl . '/lib/jquery.mousewheel-3.0.6.pack.js', CClientScript::POS_HEAD);

            if ($this->easingEnabled)
                Yii::app()->clientScript->registerScriptFile($baseUrl . '/lib/jquery.easing-1.3.js', CClientScript::POS_HEAD);
        }
        else
            throw new Exception('FancyBox - Error: папка с плагином не найдена.');
    }
}