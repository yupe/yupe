<?php
class ModuleInfoWidget extends CWidget
{
    public $module;

    public function init()
    {
        if (!is_null($this->controller->module)) {
            $this->module = $this->controller->module;
        }
    }

    public function run()
    {
        $this->render('moduleinfowidget', array('module' => $this->module));
    }
}

?>