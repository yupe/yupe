<?php

/**
 * Форма для запроса смены пароля
 *
 * @category YupeComponents
 * @package  yupe.modules.user.forms
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @version  0.5.3
 * @link     http://yupe.ru
 *
 **/
class RecoveryForm extends CFormModel
{
    public $email;

    public function rules()
    {
        return [
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'checkEmail'],
        ];
    }

    public function checkEmail($attribute, $params)
    {
        if ($this->hasErrors() === false) {
            $user = User::model()->active()->find(
                'email = :email',
                [
                    ':email' => $this->$attribute
                ]
            );

            if ($user === null) {
                $this->addError(
                    '',
                    Yii::t(
                        'UserModule.user',
                        'Email "{email}" was not found or user was blocked !',
                        [
                            '{email}' => $this->email
                        ]
                    )
                );
            }
        }
    }
}
