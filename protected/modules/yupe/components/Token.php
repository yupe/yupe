<?php
/**
 * Файл компонента для работы с токенами:
 *
 * @category YupeComponents
 * @package  yupe.modules.user.components
 * @author   AKulikov (im@kukov.im)
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @version  0.6
 * @link     http://yupe.ru
 *
 **/

namespace yupe\components;

use Yii;
use yupe\components\WebModule;

// Импортируем нужные модели:
Yii::import('application.modules.user.models.User');
Yii::import('application.modules.user.models.UserToken');

use User;
use UserToken;
use CMap;

class Token extends \CComponent
{
    /**
     * Отправка письма с активацией токена:
     * 
     * @param User    $user      - пользователь
     * @param mixed   $view      - вьюха для отрисовки письма
     * @param mixed   $data      - данные для вьюхи
     * @param boolean $newToken  - инвалидировать старый и создать новый токен
     * @param string  $type      - тип токена
     * @param string  $newMethod - метод для создания нового токена данного типа
     * @param string  $mailTheme - тема письма
     * 
     * @return mixed
     */
    protected static function send(User $user, $view, $data, $newToken, $type, $newMethod, $mailTheme)
    {
        // Если сказано инвалидировать старый токен
        // так и поступаем:
        if ($newToken === true) {
            // Если есть ещё токены данного типа - инвалидируем их:
            $user->$type instanceof UserToken === false || $user->$type->compromise() && $user->refresh();
        }
        
        // Если нет токена - создаём:
        $user->$type instanceof UserToken || UserToken::$newMethod($user) && $user->refresh();

        /**
         * Рендерим тело письма:
         *
         * @todo пока реализация требует наличия вьюшки,
         *       но когда будут нормально реализованы 
         *       почтоыве шаблоны - можно спокойно поправить
         *       на шаблоны:
         */
        $emailBody = Yii::app()->controller->renderPartial(
            $view, CMap::mergeArray(
                (array) $data, array(
                    'model' => $user
                )
            ), true
        );

        // Отправляем почту:
        Yii::app()->mail->send(
            Yii::app()->getModule('user')->notifyEmailFrom,
            $user->email,
            $mailTheme,
            $emailBody
        );

        // Если ajax -  возвращаем данные:
        if (Yii::app()->getRequest()->getIsAjaxRequest() === true) {
            return Yii::app()->ajax->success(
                Yii::t('YupeModule.yupe', 'Letter sent!')
            );
        }

        return true;
    }

    /**
     * Отправка письма для подтверждения Email:
     * 
     * @param User    $user     - пользователь
     * @param mixed   $view     - вьюха для отрисовки письма
     * @param mixed   $data     - данные для вьюхи
     * @param boolean $newToken - инвалидировать старый и создать новый токен
     * 
     * @return void
     */
    public static function sendEmailVerify(User $user, $view = null, $newToken = false, $data = array())
    {
        return self::send(
            $user, $view, array(), $newToken,
            'verify', 'newVerifyEmail',
            Yii::t(
                'UserModule.user',
                'New e-mail confirmation for {site}!',
                array('{site}' => Yii::app()->getModule('yupe')->siteName)
            )
        );
    }

    /**
     * Отправка письма для активации пользователя:
     * 
     * @param User    $user     - пользователь
     * @param mixed   $view     - вьюха для отрисовки письма
     * @param mixed   $data     - данные для вьюхи
     * @param boolean $newToken - инвалидировать старый и создать новый токен
     * 
     * @return void
     */
    public static function sendActivation(User $user, $view = null, $newToken = false, $data = array())
    {
        return self::send(
            $user, $view, array(), $newToken,
            'reg', 'newActivate',
            Yii::t(
                'UserModule.user',
                'Registration on {site}',
                array('{site}' => Yii::app()->getModule('yupe')->siteName)
            )
        );
    }

    /**
     * Отправка письма для сброса пароля:
     * 
     * @param User    $user     - пользователь
     * @param mixed   $view     - вьюха для отрисовки письма
     * @param mixed   $data     - данные для вьюхи
     * @param boolean $newToken - инвалидировать старый и создать новый токен
     * 
     * @return void
     */
    public static function sendReset(User $user, $view = null, $data = array(), $newToken = true)
    {
        return self::send(
            $user, $view, $data, $newToken,
            'recovery', 'newRecovery',
            Yii::t('UserModule.user', 'Password recovery!')
        );
    }

    /**
     * Метод активации токена:
     * 
     * @param User   $user - пользователь
     * @param string $type - тип токена
     * 
     * @return boolean - статус выполнения
     */
    protected static function activate(User $user, $type)
    {
        // Если не токена - плохой запрос:
        $user->$type instanceof UserToken === true || Yii::app()->controller->badRequest();

        // Обновляем статус:
        return $user->$type->activate();
    }

    /**
     * Активация пользователя:
     * 
     * @param User $user - пользователь
     * 
     * @return boolean - статус выполнения
     */
    public static function userActivate(User $user)
    {
        return self::activate($user, 'reg')
            && self::activate($user, 'verify');
    }

    /**
     * Подтверждение Email пользователя:
     * 
     * @param User $user - пользователь
     * 
     * @return boolean - статус выполнения
     */
    public static function confirmEmail(User $user)
    {
        return self::activate($user, 'verify');
    }
}