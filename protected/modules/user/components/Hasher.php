<?php

class Hasher extends CApplicationComponent
{
    public function init()
    {
        parent::init();
    }

    public function hashPassword($password, array $params = array())
    {
        return CPasswordHelper::hashPassword($password);
    }

    public function checkPassword($password, $hash)
    {
        return CPasswordHelper::verifyPassword($password, $hash);
    }

    public function generateRandomToken($length = 32)
    {
        return Yii::app()->getSecurityManager()->generateRandomString((int)$length);
    }

    public function generateRandomPassword($length = 8)
    {
        return substr($this->generateRandomToken(), 0, $length);
    }
}
