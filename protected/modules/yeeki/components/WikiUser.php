<?php
/**
 * WikiUser переопределяет переменные необходимые в модуле yeeki
 */
class WikiUser implements IWikiUser
{
    /**
     * @param mixed $id ID пользователя
     * @return string логин пользователя
     */
    public function getNameById($id)
    {
        $user = User::model()->findByPk($id);
        return $user->name;
    }

    /**
     * @param int $id ID пользователя
     * @return string email пользователя
     */
    public function getEmailById($id)
    {
        $user = User::model()->findByPk($id);
        return $user->email;
    }
}