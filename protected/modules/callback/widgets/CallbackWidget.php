<?php

Yii::import('application.modules.callback.models.*');

class CallbackWidget extends \yupe\widgets\YWidget
{
    public $view = 'default';

    public function init()
    {
        Yii::app()->getClientScript()->registerScriptFile(Yii::app()->getAssetManager()->publish(
            Yii::getPathOfAlias('application.modules.callback.views.web') . '/callback.js'
        ), CClientScript::POS_END);

        parent::init();
    }

    public function run()
    {
        $module = Yii::app()->getModule('callback');

        $this->render($this->view, [
            'model' => Callback::model(),
            'phoneMask' => $module->phoneMask,
        ]);
    }
}