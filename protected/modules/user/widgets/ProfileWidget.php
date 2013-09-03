<?php
/**
 * Created by JetBrains PhpStorm.
 * User: andrey
 * Date: 9/3/13
 * Time: 9:46 PM
 * To change this template use File | Settings | File Templates.
 */

class ProfileWidget extends YWidget
{
    public function run()
    {
        if(Yii::app()->user->isAuthenticated()) {
            $this->render('profile-widget', array('user' => Yii::app()->user->getProfile()));
        }
    }
}