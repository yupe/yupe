<?php

class TemplateListener
{
    public static function js()
    {
        Yii::app()->getController()->renderPartial('application.modules.favorite.view.js');
    }
}