<?php
class YupeStartUpBehavior extends CBehavior
{
    public function attach($owner)
    {
        $owner->attachEventHandler('onbeginRequest', array($this, 'beginRequest'));
    }

    public function beginRequest(CEvent $event)
    {
        // Обрабатываем правила маршрутизации текущего модуля, если указаны
        list( $module ) = explode("/",Yii::app()->getRequest()->getPathInfo());        
        if(Yii::app()->hasModule($module) && ($module=Yii::app()->getModule($module)) && isset($module->urlRules))
            Yii::app()->getUrlManager()->addRules($module->urlRules);
    }
}