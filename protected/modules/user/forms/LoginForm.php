<?php
class LoginForm extends YFormModel
{
    public $email;
    public $password;
    private $_identity;

    public function rules()
    {
        return array(
            array('email, password', 'required'),
            array('email', 'email'),
            array('password', 'authenticate'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'email'    => Yii::t('UserModule.user', 'Email'),
            'password' => Yii::t('UserModule.user', 'Пароль'),
        );
    }

    public function attributeDescriptions()
    {
        return array(
            'email'    => Yii::t('UserModule.user', 'Email'),
            'password' => Yii::t('UserModule.user', 'Пароль'),
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
        }
    }
}