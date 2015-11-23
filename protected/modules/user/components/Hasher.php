<?php

/**
 * Class Hasher
 */
class Hasher extends CApplicationComponent
{
    /**
     * @param $password
     * @param array $params
     * @return string
     * @throws CException
     */
    public function hashPassword($password, array $params = [])
    {
        return CPasswordHelper::hashPassword($password);
    }

    /**
     * @param $password
     * @param $hash
     * @return bool
     */
    public function checkPassword($password, $hash)
    {
        return CPasswordHelper::verifyPassword($password, $hash);
    }

    /**
     * @param int $length
     * @return mixed
     */
    public function generateRandomToken($length = 32)
    {
        return Yii::app()->getSecurityManager()->generateRandomString((int)$length);
    }

    /**
     * @param int $length
     * @return string
     */
    public function generateRandomPassword($length = 8)
    {
        return substr($this->generateRandomToken(), 0, $length);
    }
}
