<?php

Yii::import('application.modules.callback.models.*');

class CallbackWidget extends \yupe\widgets\YWidget
{
    public $view = 'default';

    public function run()
    {
        $module = Yii::app()->getModule('callback');

        $this->render($this->view, [
            'model' => Callback::model(),
            'phoneMask' => $module->phoneMask,
        ]);
    }
}