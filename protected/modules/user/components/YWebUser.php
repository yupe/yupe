<?php
class YWebUser extends CWebUser
{
    public function isAuthenticated()
    {
        if (Yii::app()->user->isGuest)        
            return false;       

        $authData = $this->getAuthData();

        if ($authData['nick_name'] && isset($authData['access_level']) && $authData['loginTime'] && $authData['id'])       
            return true;        

        return false;
    }

    protected function getAuthData()
    {
        return array(
            'nick_name' => Yii::app()->user->getState('nick_name'),
            'access_level' => (int)Yii::app()->user->getState('access_level'),
            'loginTime' => Yii::app()->user->getState('loginTime'),
            'id' => (int)Yii::app()->user->getState('id')
        );
    }

    public function isSuperUser()
    {
        if (!$this->isAuthenticated())        
            return false;        

        $loginAdmTime = Yii::app()->user->getState('loginAdmTime');

        $isAdmin = Yii::app()->user->getState('isAdmin');

        if ($isAdmin == User::ACCESS_LEVEL_ADMIN && $loginAdmTime)        
            return true;        

        return false;
    }    
}