<?php
class YWebUser extends CWebUser
{
    private $_profile;

    public function isAuthenticated()
    {
        if (Yii::app()->user->isGuest)
            return false;

        $authData = $this->getAuthData();

        if(!User::model()->findByPk($authData['id']))
        {
            $_SESSION = array();
            return false;
        }

        if ($authData['nick_name'] && isset($authData['access_level']) && $authData['loginTime'] && $authData['id'])
            return true;

        return false;
    }

    protected function getAuthData()
    {
        return array(
            'nick_name'    => Yii::app()->user->getState('nick_name'),
            'access_level' => (int) Yii::app()->user->getState('access_level'),
            'loginTime'    => Yii::app()->user->getState('loginTime'),
            'id'           => (int) Yii::app()->user->getState('id'),
        );
    }

    public function isSuperUser()
    {
        if (!$this->isAuthenticated())
            return false;

        $loginAdmTime = Yii::app()->user->getState('loginAdmTime');
        $isAdmin      = Yii::app()->user->getState('isAdmin');

        if ($isAdmin == User::ACCESS_LEVEL_ADMIN && $loginAdmTime)
            return true;

        return false;
    }

    // TODO: Реализовать выборку любого профиля
    public function getProfile( $moduleName=null )
    {
        if ( !$moduleName )
        {
            if ( $this->_profile === null )
                $this->_profile = User::model()->findByPk($this->id);

            return $this->_profile;
        }
        return null;
    }

}