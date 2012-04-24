<?php
class RegistrationForm extends CFormModel
{
    public $nick_name;

    public $email;

    public $password;
    
    public $cPassword;

    public $verifyCode;

    public $about;

    public function rules()
    {
        $module = Yii::app()->getModule('user');
        
        return array(
            array('nick_name, email','filter','filter' => 'trim'),
            array('nick_name, email','filter','filter' => array($obj = new CHtmlPurifier(),'purify')),
            array('nick_name, email, password, cPassword', 'required'),
            array('nick_name, email', 'length', 'max' => 50),                        
            array('password, cPassword', 'length', 'min' => $module->minPasswordLength),
            array('nick_name','match','pattern' => '/^[A-Za-z0-9]{2,50}$/','message' => Yii::t('user','Неверный формат поля "{attribute}" допустимы только буквы и цифры, от 2 до 20 символов')),
            array('nick_name','checkNickName'),
            array('password', 'compare', 'compareAttribute' => 'cPassword', 'message' => Yii::t('user', 'Пароли не совпадают.')),
            array('email','email'),                                    
            array('email','checkEmail'),
            array('verifyCode', 'YRequiredValidator', 'allowEmpty' => !$module->showCaptcha,'message' => Yii::t('user','Код проверки не корректен.')),
            array('verifyCode', 'captcha', 'allowEmpty' => !$module->showCaptcha),            
        );
    }

    public function checkNickName($attribute,$params)
    {
        $model = User::model()->find('nick_name = :nick_name',array(
            ':nick_name' => $this->nick_name
        ));

        if($model)        
            $this->addError('nick_name',Yii::t('user','Ник уже занят'));
    }

    public function checkEmail($attribute,$params)
    {
        $model = User::model()->find('email = :email',array(
            ':email' => $this->email
        ));

        if($model)        
            $this->addError('email',Yii::t('user','Email уже занят'));   
    }

    public function attributeLabels()
    {
        return array(
            'nick_name' => Yii::t('user', 'Имя пользователя'),
            'email' => Yii::t('user', 'Email'),
            'password' => Yii::t('user', 'Пароль'),
            'cPassword' => Yii::t('user', 'Подтверждение пароля'),
            'verifyCode' => Yii::t('user', 'Код проверки'),            
        );
    }
}