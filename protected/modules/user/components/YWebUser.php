<?php
class YWebUser extends CWebUser
{
    public function isAuthenticated()
    {
        if (Yii::app()->user->isGuest)
        {
            return false;
        }

        $authData = $this->getAuthData();

        if ($authData['nickName'] && isset($authData['accessLevel']) && $authData['loginTime'] && $authData['id'])
        {

            return true;
        }

        return false;
    }

    protected function getAuthData()
    {
        return array(
            'nickName' => Yii::app()->user->getState('nickName'),
            'accessLevel' => (int)Yii::app()->user->getState('accessLevel'),
            'loginTime' => Yii::app()->user->getState('loginTime'),
            'id' => (int)Yii::app()->user->getState('id')
        );
    }


    public function isSuperUser()
    {
        if (!$this->isAuthenticated())
        {
            return false;
        }

        $loginAdmTime = Yii::app()->user->getState('loginAdmTime');

        $isAdmin = Yii::app()->user->getState('isAdmin');

        if ($isAdmin == User::ACCESS_LEVEL_ADMIN && $loginAdmTime)
        {
            return true;
        }

        return false;
    }

    public function getProfile()
    {
        return User::model()->active()->with('profile')->findByPk((int)Yii::app()->user->getId());
    }
}

?>