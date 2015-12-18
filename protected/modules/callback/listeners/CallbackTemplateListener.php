<?php

class CallbackTemplateListener
{
    public static function js()
    {
        Yii::app()->getController()->renderPartial('application.modules.callback.views.js');
    }
}