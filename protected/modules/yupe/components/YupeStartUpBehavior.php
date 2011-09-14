<?php
class YupeStartUpBehavior extends CBehavior
{
    public function attach($owner)
    {
        $owner->attachEventHandler('onbeginRequest', array($this, 'beginRequest'));
    }

    public function beginRequest(CEvent $event)
    {
        try
        {
            $yupeModule = Yii::app()->getModule('yupe');

            if ($yupeModule && $yupeModule->theme) {
                Yii::app()->theme = $yupeModule->theme;
            }

        }
        catch (CDbException $e)
        {
            //.....
        }
    }
}

?>