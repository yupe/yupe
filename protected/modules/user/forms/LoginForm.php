<?php
class LoginForm extends CFormModel
{
    public $nick_name;

    public $password;

    private $_identity;

    public function rules()
    {
        return array(
            array('nick_name, password', 'required'),            
            array('password', 'authenticate')
        );
    }

    public function attributeLabels()
    {
        return array(
            'nick_name' => Yii::t('user', 'Логин'),
            'password'  => Yii::t('user', 'Пароль'),
        );
    }

    public function authenticate()
    {
        if (!$this->hasErrors())
        {
            $this->_identity = new UserIdentity($this->nick_name, $this->password);

            if (!$this->_identity->authenticate())            
                $this->addError('password', Yii::t('user', 'Логин или пароль введены неверно!'));            
            else            
                Yii::app()->user->login($this->_identity);            
        }
    }
}