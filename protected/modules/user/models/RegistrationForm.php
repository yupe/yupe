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
            array('nick_name, email, password, cPassword', 'required'),
            array('email', 'email'),
            array('password', 'compare', 'compareAttribute' => 'cPassword', 'message' => Yii::t('user', 'Пароли не совпадают!')),
            array('nick_name, email', 'filter', 'filter' => 'trim'),
            array('password,cPassword', 'length', 'min' => $module->minPasswordLength, 'max' => $module->maxPasswordLength),
            array('verifyCode', 'YRequiredValidator', 'allowEmpty' => !$module->showCaptcha),
            array('verifyCode', 'captcha', 'allowEmpty' => !$module->showCaptcha),
            array('about', 'length', 'max' => 400)
        );
    }

    public function attributeLabels()
    {
        return array(
            'nick_name' => Yii::t('user', 'Имя пользователя'),
            'email' => Yii::t('user', 'Email'),
            'password' => Yii::t('user', 'Пароль'),
            'cPassword' => Yii::t('user', 'Подтверждение пароля'),
            'verifyCode' => Yii::t('user', 'Код проверки'),
            'about' => Yii::t('user', 'О себе')
        );
    }
}

?>


