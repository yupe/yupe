<?php

/**
 * Форма регистрации
 *
 * @category YupeComponents
 * @package  yupe.modules.user.forms
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @version  0.5.3
 * @link     http://yupe.ru
 *
 **/
class RegistrationForm extends CFormModel
{

    public $nick_name;
    public $email;
    public $password;
    public $cPassword;
    public $verifyCode;

    public $disableCaptcha = false;

    public function isCaptchaEnabled()
    {
        $module = Yii::app()->getModule('user');

        if (!$module->showCaptcha || !CCaptcha::checkRequirements() || $this->disableCaptcha) {
            return false;
        }

        return true;
    }

    public function rules()
    {
        $module = Yii::app()->getModule('user');

        return [
            ['nick_name, email', 'filter', 'filter' => 'trim'],
            ['nick_name, email', 'filter', 'filter' => [new CHtmlPurifier(), 'purify']],
            ['nick_name, email, password, cPassword', 'required'],
            ['nick_name, email', 'length', 'max' => 50],
            ['password, cPassword', 'length', 'min' => $module->minPasswordLength],
            [
                'nick_name',
                'match',
                'pattern' => '/^[A-Za-z0-9_-]{2,50}$/',
                'message' => Yii::t(
                    'UserModule.user',
                    'Bad field format for "{attribute}". You can use only letters and digits from 2 to 20 symbols'
                )
            ],
            ['nick_name', 'checkNickName'],
            [
                'cPassword',
                'compare',
                'compareAttribute' => 'password',
                'message' => Yii::t('UserModule.user', 'Password is not coincide')
            ],
            ['email', 'email'],
            ['email', 'checkEmail'],
            [
                'verifyCode',
                'yupe\components\validators\YRequiredValidator',
                'allowEmpty' => !$this->isCaptchaEnabled(),
                'message' => Yii::t('UserModule.user', 'Check code incorrect')
            ],
            ['verifyCode', 'captcha', 'allowEmpty' => !$this->isCaptchaEnabled()],
            ['verifyCode', 'emptyOnInvalid']
        ];
    }

    /**
     * Метод выполняется перед валидацией
     *
     * @return bool
     */
    public function beforeValidate()
    {
        $module = Yii::app()->getModule('user');

        if ($module->generateNickName) {
            $this->nick_name = 'user' . time();
        }

        return parent::beforeValidate();
    }

    public function attributeLabels()
    {
        return [
            'nick_name' => Yii::t('UserModule.user', 'User name'),
            'email' => Yii::t('UserModule.user', 'Email'),
            'password' => Yii::t('UserModule.user', 'Password'),
            'cPassword' => Yii::t('UserModule.user', 'Password confirmation'),
            'verifyCode' => Yii::t('UserModule.user', 'Check code'),
        ];
    }

    public function checkNickName($attribute, $params)
    {
        $model = User::model()->find('nick_name = :nick_name', [':nick_name' => $this->$attribute]);

        if ($model) {
            $this->addError('nick_name', Yii::t('UserModule.user', 'User name already exists'));
        }
    }

    public function checkEmail($attribute, $params)
    {
        $model = User::model()->find('email = :email', [':email' => $this->$attribute]);

        if ($model) {
            $this->addError('email', Yii::t('UserModule.user', 'Email already busy'));
        }
    }

    public function emptyOnInvalid($attribute, $params)
    {
        if ($this->hasErrors()) {
            $this->verifyCode = null;
        }
    }
}
