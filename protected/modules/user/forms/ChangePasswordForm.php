<?php

/**
 * Форма смены пароля
 *
 * @category YupeComponents
 * @package  yupe.modules.user.forms
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @version  0.5.3
 * @link     http://yupe.ru
 *
 **/
class ChangePasswordForm extends CFormModel
{
    public $password;
    public $cPassword;

    public function rules()
    {
        return [
            ['password, cPassword', 'required'],
            ['password, cPassword', 'length', 'min' => Yii::app()->getModule('user')->minPasswordLength],
            [
                'password',
                'compare',
                'compareAttribute' => 'cPassword',
                'message'          => Yii::t('UserModule.user', 'Password is not coincide!')
            ]
        ];
    }

    public function attributeLabels()
    {
        return [
            'password'  => Yii::t('UserModule.user', 'New password'),
            'cPassword' => Yii::t('UserModule.user', 'Confirm new password'),
        ];
    }
}
