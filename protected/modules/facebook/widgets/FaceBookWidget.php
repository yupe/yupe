<?php
class FaceBookWidget extends CWidget
{
    public function init()
    {
        Yii::app()->clientScript->registerScriptFile("http://connect.facebook.net/en_US/all.js", CClientScript::POS_HEAD);
    }

    public function run()
    {
        Yii::app()->clientScript->registerScript("
               FB.init({ 
                    appId:'YOUR_APP_ID', cookie:true, 
                    status:true, xfbml:true 
                 });", CClientScript::POS_BEGIN);

        echo CHtml::tag('div', array('id' => 'fb-root')), CHtml::closeTag('div');
    }

}

?>
