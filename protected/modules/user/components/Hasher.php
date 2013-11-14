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
    
    public function generateRandomToken()
    {
        return str_shuffle(sha1(uniqid().spl_object_hash($this).microtime(true)));
    }
}
