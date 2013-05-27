<?php
class LoginForm extends YFormModel
{
    public $email;
    public $password;
    public $verifyCode;
    private $_identity;

    public function rules()
    {
        $module = Yii::app()->getModule('user');

        return array(
            array('email, password', 'required'),
            array('email', 'email'),
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
            'verifyCode' => Yii::t('UserModule.user', 'Код проверки'),
        );
    }

    public function attributeDescriptions()
    {
        return array(
            'email'      => Yii::t('UserModule.user', 'Email'),
            'password'   => Yii::t('UserModule.user', 'Пароль'),
            'verifyCode' => Yii::t('UserModule.user', 'Код проверки'),
        );
    }

    public function authenticate()
    {
        if (!$this->hasErrors())
        {
            $this->_identity = new UserIdentity($this->email, $this->password);

            if (!$this->_identity->authenticate())
                $this->addError('password', Yii::t('UserModule.user', 'Email или пароль введены неверно!'));
            else
                Yii::app()->user->login($this->_identity);

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