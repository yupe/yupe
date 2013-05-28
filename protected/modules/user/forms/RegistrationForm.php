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
            array('nick_name, email', 'filter', 'filter' => 'trim'),
            array('nick_name, email', 'filter', 'filter' => array($obj = new CHtmlPurifier(), 'purify')),
            array('nick_name, email, password, cPassword', 'required'),
            array('nick_name, email', 'length', 'max' => 50),
            array('password, cPassword', 'length', 'min' => $module->minPasswordLength),
            array('nick_name', 'match','pattern' => '/^[A-Za-z0-9]{2,50}$/', 'message' => Yii::t('UserModule.user', 'Неверный формат поля "{attribute}" допустимы только буквы и цифры, от 2 до 20 символов')),
            array('nick_name', 'checkNickName'),
            array('cPassword', 'compare', 'compareAttribute' => 'password', 'message' => Yii::t('UserModule.user', 'Пароли не совпадают.')),
            array('email', 'email'),
            array('email', 'checkEmail'),
            array('verifyCode', 'YRequiredValidator', 'allowEmpty' => !$module->showCaptcha || !CCaptcha::checkRequirements(), 'message' => Yii::t('UserModule.user', 'Код проверки не корректен.')),
            array('verifyCode', 'captcha', 'allowEmpty' => !$module->showCaptcha || !CCaptcha::checkRequirements()),
            array('verifyCode', 'emptyOnInvalid'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'nick_name'  => Yii::t('UserModule.user', 'Имя пользователя'),
            'email'      => Yii::t('UserModule.user', 'Email'),
            'password'   => Yii::t('UserModule.user', 'Пароль'),
            'cPassword'  => Yii::t('UserModule.user', 'Подтверждение пароля'),
            'verifyCode' => Yii::t('UserModule.user', 'Код проверки'),
        );
    }

    public function beforeValidate()
    {
        if (Yii::app()->getModule('user')->autoNick)
            $this->nick_name = substr(User::model()->generateSalt(), 10);
        return parent::beforeValidate();
    }

    public function checkNickName($attribute,$params)
    {
        $model = User::model()->find('nick_name = :nick_name', array(':nick_name' => $this->$attribute));
        if ($model)
            $this->addError('nick_name', Yii::t('UserModule.user', 'Ник уже занят'));
    }

    public function checkEmail($attribute,$params)
    {
        $model = User::model()->find('email = :email', array(':email' => $this->$attribute));
        if ($model)
            $this->addError('email', Yii::t('UserModule.user', 'Email уже занят'));
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