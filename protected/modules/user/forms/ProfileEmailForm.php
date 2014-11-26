<?php

/**
 * Форма изменения email профиля
 *
 * @category YupeComponents
 * @package  yupe.modules.user.forms
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @version  0.8
 * @link     http://yupe.ru
 *
 **/
class ProfileEmailForm extends CFormModel
{
    public $email;

    public function rules()
    {
        return [
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'filter', 'filter' => [$obj = new CHtmlPurifier(), 'purify']],
            ['email', 'required'],
            ['email', 'length', 'max' => 50],
            ['email', 'email'],
            ['email', 'checkEmail'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'email' => Yii::t('UserModule.user', 'Email'),
        ];
    }

    public function checkEmail($attribute, $params)
    {
        // Если мыло поменяли
        if (Yii::app()->user->profile->email != $this->$attribute) {
            $model = User::model()->find('email = :email', [':email' => $this->$attribute]);
            if ($model) {
                $this->addError('email', Yii::t('UserModule.user', 'Email already busy'));
            }
        }
    }
}
