<?php

class Hasher extends CApplicationComponent
{
    public function hashPassword($password, array $params = array())
    {
        return CPasswordHelper::hashPassword($password);
    }
    
    public function checkPassword($password, $hash)
    {
        return CPasswordHelper::verifyPassword($password, $hash);
    }
    
    public function generateRandomToken($length = 64)
    {
        return md5(time().date('d-m-Y'));
    }
}
