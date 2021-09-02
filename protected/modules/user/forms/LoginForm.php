<?php

/**
 * Форма авторизации
 *
 * @category YupeComponents
 * @package  yupe.modules.user.forms
 * @author   YupeTeam <support@yupe.ru>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @version  0.5.3
 * @link     https://yupe.ru
 *
 **/
class LoginForm extends yupe\models\YFormModel
{
    /**
     *
     */
    const LOGIN_LIMIT_SCENARIO = 'loginLimit';

    /**
     * @var
     */
    public $email;
    /**
     * @var
     */
    public $password;
    /**
     * @var
     */
    public $remember_me;
    /**
     * @var
     */
    public $verifyCode;

    /**
     * @return array
     */
    public function rules()
    {
        $module = Yii::app()->getModule('user');

        return [
            ['email, password', 'required'],
            ['verifyCode', 'required', 'on' => self::LOGIN_LIMIT_SCENARIO],
            ['remember_me', 'boolean'],
            [
                'verifyCode',
                'yupe\components\validators\YRequiredValidator',
                'allowEmpty' => !$module->showCaptcha || !CCaptcha::checkRequirements(),
                'message' => Yii::t('UserModule.user', 'Check code incorrect'),
                'on' => self::LOGIN_LIMIT_SCENARIO,
            ],
            [
                'verifyCode',
                'captcha',
                'allowEmpty' => !$module->showCaptcha || !CCaptcha::checkRequirements(),
                'on' => self::LOGIN_LIMIT_SCENARIO,
            ],
            ['verifyCode', 'emptyOnInvalid'],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'email' => Yii::t('UserModule.user', 'Email/Login'),
            'password' => Yii::t('UserModule.user', 'Password'),
            'remember_me' => Yii::t('UserModule.user', 'Remember me'),
            'verifyCode' => Yii::t('UserModule.user', 'Check code'),
        ];
    }

    /**
     * @return array
     */
    public function attributeDescriptions()
    {
        return [
            'email' => Yii::t('UserModule.user', 'Email/Login'),
            'password' => Yii::t('UserModule.user', 'Password'),
            'remember_me' => Yii::t('UserModule.user', 'Remember me'),
            'verifyCode' => Yii::t('UserModule.user', 'Check code'),
        ];
    }

    /**
     * Обнуляем введённое значение капчи, если оно введено неверно:
     *
     * @param string $attribute - имя атрибута
     * @param mixed $params - параметры
     *
     * @return void
     **/
    public function emptyOnInvalid($attribute, $params)
    {
        if ($this->hasErrors()) {
            $this->verifyCode = null;
        }
    }
}
