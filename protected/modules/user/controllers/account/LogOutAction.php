<?php
/**
 * Экшн, отвечающий за разлогинивание пользователя
 *
 * @category YupeComponents
 * @package  yupe.modules.user.controllers.account
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @version  0.7
 * @link     http://yupe.ru
 *
 **/
use yupe\helpers\Url;

class LogOutAction extends CAction
{
    public function run()
    {
        Yii::app()->authenticationManager->logout(Yii::app()->getUser());

        $this->getController()->redirect(Url::redirectUrl(Yii::app()->getModule('user')->logoutSuccess));
    }
}