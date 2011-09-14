<?php
class RegistrationForm extends CFormModel
{
      public $nickName;
      public $email;
      public $password;
      public $cPassword;
      public $verifyCode;
      public $about;
      
      public function rules()
      {
            return array(
                array('nickName, email, password, cPassword', 'required'),
                array('email','email'),
                array('password','compare','compareAttribute' => 'cPassword','message' => Yii::t('user','Пароли не совпадают!')),
                array('nickName, email','filter','filter' => 'trim'),
                array('password,cPassword','length','min' => Yii::app()->getModule('user')->minPasswordLength,'max' => Yii::app()->getModule('user')->maxPasswordLength),
                array('verifyCode','YRequiredValidator','allowEmpty' => !Yii::app()->getModule('user')->showCaptcha),
                array('verifyCode','captcha' ,'allowEmpty' => !Yii::app()->getModule('user')->showCaptcha),
                array('about','length','max' => 400)
            );
      }      
      
      public function attributeLabels()
      {
            return array(
                'nickName'    => Yii::t('user','Имя пользователя'),
                'email'       => Yii::t('user','Email'),
                'password'    => Yii::t('user','Пароль'),
                'cPassword'   => Yii::t('user','Подтверждение пароля'),
                'verifyCode'  => Yii::t('user','Код проверки'),
                'about'       => Yii::t('user','О себе')
            );
      }
}
?>


