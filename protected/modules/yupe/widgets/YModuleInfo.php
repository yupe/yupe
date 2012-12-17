<?php

class YModuleInfo extends YWidget
{
    public $module;

    public function init()
    {
        if (!$this->module && is_object($this->controller->module))
            $this->module = $this->controller->module;
    }

    public function run()
    {
        $this->render('moduleinfowidget', array('module' => $this->module));
    }
}