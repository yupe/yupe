<?php

Yii::import('application.modules.callback.models.*');

/**
 * Class CallbackWidget
 */
class CallbackWidget extends \yupe\widgets\YWidget
{
    /**
     * @var string
     */
    public $view = 'default';

    /**
     * @throws CException
     */
    public function init()
    {
        $cs = Yii::app()->getClientScript();
        $cs->registerCoreScript('maskedinput');

        $cs->registerScriptFile(Yii::app()->getAssetManager()->publish(
            Yii::getPathOfAlias('application.modules.callback.views.web') . '/maskedInputInit.js'
        ), CClientScript::POS_END);

        $cs->registerScriptFile(Yii::app()->getAssetManager()->publish(
            Yii::getPathOfAlias('application.modules.callback.views.web') . '/callback.js'
        ), CClientScript::POS_END);


        parent::init();

    }

    /**
     * @throws CException
     */
    public function run()
    {
        $module = Yii::app()->getModule('callback');

        $this->render($this->view, [
            'model' => Callback::model(),
            'phoneMask' => $module->phoneMask // Маска оставлена, только для темы default
        ]);
    }
}