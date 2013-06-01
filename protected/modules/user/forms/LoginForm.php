<?php
class LoginForm extends YFormModel
{
    public $email;
    public $password;
    public $remember_me;
    public $verifyCode;
    private $_identity;

    public function rules()
    {
        $module = Yii::app()->getModule('user');

        return array(
            array('email, password', 'required'),
            array('email', 'email'),
            array('remember_me','boolean'),
            array('verifyCode', 'YRequiredValidator', 'allowEmpty' => !$module->showCaptcha || !CCaptcha::checkRequirements(), 'message' => Yii::t('UserModule.user', 'Код проверки не корректен.'), 'on' => 'loginLimit'),
            array('verifyCode', 'captcha', 'allowEmpty' => !$module->showCaptcha || !CCaptcha::checkRequirements(), 'on' => 'loginLimit'),
            array('verifyCode', 'emptyOnInvalid'),
            array('password', 'authenticate'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'email'      => Yii::t('UserModule.user', 'Email'),
            'password'   => Yii::t('UserModule.user', 'Пароль'),
            'remember_me'=> Yii::t('UserModule.user', 'Запомнить меня'),
            'verifyCode' => Yii::t('UserModule.user', 'Код проверки'),
        );
    }

    public function attributeDescriptions()
    {
        return array(
            'email'      => Yii::t('UserModule.user', 'Email'),
            'password'   => Yii::t('UserModule.user', 'Пароль'),
            'remember_me'=> Yii::t('UserModule.user', 'Запомнить меня'),
            'verifyCode' => Yii::t('UserModule.user', 'Код проверки'),
        );
    }

    public function authenticate()
    {
        if (!$this->hasErrors())
        {
            $this->_identity = new UserIdentity($this->email, $this->password);

            $duration = 0;

            if($this->remember_me)
            {
                $sessionTimeInWeeks = (int)Yii::app()->getModule('user')->sessionLifeTime;
                $duration = $sessionTimeInWeeks*24*60*60;
            }

            if (!$this->_identity->authenticate())
                $this->addError('password', Yii::t('UserModule.user', 'Email или пароль введены неверно!'));
            else
                Yii::app()->user->login($this->_identity, $duration);

            $this->verifyCode = null;
        }
    }

    /**
     * Обнуляем введённое значение капчи, если оно введено неверно:
     *
     * @param string $attribute - имя атрибута
     * @param mixed  $params    - параметры
     *
     * @return void
     **/
    public function emptyOnInvalid($attribute, $params)
    {
        if ($this->hasErrors())
            $this->verifyCode = null;
    }
}