<?php
/**
 * Экшн, отвечающий за разлогинивание пользователя
 *
 * @category YupeComponents
 * @package  yupe.modules.user.controllers.account
 * @author   YupeTeam <support@yupe.ru>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @version  0.7
 * @link     https://yupe.ru
 *
 **/
use yupe\helpers\Url;

/**
 * Class LogOutAction
 */
class LogOutAction extends CAction
{
    /**
     *
     */
    public function run()
    {
        if (Yii::app()->getUser()->getIsGuest()) {
            $this->getController()->redirect(['/user/account/login']);
        }

        Yii::app()->authenticationManager->logout(Yii::app()->getUser());

        $this->getController()->redirect(Url::redirectUrl(Yii::app()->getModule('user')->logoutSuccess));
    }
}