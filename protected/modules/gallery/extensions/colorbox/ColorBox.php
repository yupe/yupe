<?php

class ColorBox extends YWidget
{

    public $id;
    public $target;
    public $lang;
    public $config = array();

    public function init()
    {
        if (!isset($this->id)) {
            $this->id = $this->getId();
        }

        if (!isset($this->lang)) {
            $this->lang = Yii::app()->language;
        }

        $this->publishAssets();
    }

    public function run()
    {
        $config = CJavaScript::encode($this->config);
        Yii::app()->clientScript->registerScript(
            $this->getId(),
            "$('$this->target').colorbox($config);"
        );
    }

    public function publishAssets()
    {
        $assets = dirname(__FILE__) . '/assets';
        $baseUrl = Yii::app()->assetManager->publish($assets);

        if (is_dir($assets)) {
            Yii::app()->clientScript->registerCoreScript('jquery');
            Yii::app()->clientScript->registerCssFile($baseUrl . '/css/colorbox.css');
            Yii::app()->clientScript->registerScriptFile(
                $baseUrl . '/js/jquery.isotope.min.js',
                CClientScript::POS_HEAD
            );
            Yii::app()->clientScript->registerScriptFile(
                $baseUrl . '/js/jquery.colorbox-min.js',
                CClientScript::POS_END
            );
            Yii::app()->clientScript->registerScriptFile(
                $baseUrl . '/js/i18n/jquery.colorbox-' . $this->lang . '.js',
                CClientScript::POS_END
            );
        } else {
            throw new Exception('ColorBox - Error: папка с плагином не найдена.');
        }
    }
}
