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
    

    public function rules()
    {
        $module = Yii::app()->getModule('user');

        return array(
            array('nick_name, email', 'filter', 'filter' => 'trim'),
            array('nick_name, email', 'filter', 'filter' => array($obj = new CHtmlPurifier(), 'purify')),
            array('nick_name, email, password, cPassword', 'required'),
            array('nick_name, email', 'length', 'max' => 50),
            array('password, cPassword', 'length', 'min' => $module->minPasswordLength),
            array('nick_name', 'match','pattern' => '/^[A-Za-z0-9]{2,50}$/', 'message' => Yii::t('UserModule.user', 'Bad field format for "{attribute}". You can use only letters and digits from 2 to 20 symbols')),
            array('nick_name', 'checkNickName'),
            array('cPassword', 'compare', 'compareAttribute' => 'password', 'message' => Yii::t('UserModule.user', 'Password is not coincide')),
            array('email', 'email'),
            array('email', 'checkEmail'),
            array('verifyCode', 'yupe\components\validators\YRequiredValidator', 'allowEmpty' => !$module->showCaptcha || !CCaptcha::checkRequirements(), 'message' => Yii::t('UserModule.user', 'Check code incorrect')),
            array('verifyCode', 'captcha', 'allowEmpty' => !$module->showCaptcha || !CCaptcha::checkRequirements()),
            array('verifyCode', 'emptyOnInvalid')            
        );
    }

    public function attributeLabels()
    {
        return array(
            'nick_name'  => Yii::t('UserModule.user', 'User name'),
            'email'      => Yii::t('UserModule.user', 'Email'),
            'password'   => Yii::t('UserModule.user', 'Password'),
            'cPassword'  => Yii::t('UserModule.user', 'Password confirmation'),
            'verifyCode' => Yii::t('UserModule.user', 'Check code'),
        );
    }    

    public function checkNickName($attribute,$params)
    {
        $model = User::model()->find('nick_name = :nick_name', array(':nick_name' => $this->$attribute));

        if ($model) {
            $this->addError('nick_name', Yii::t('UserModule.user', 'User name already exists'));
        }
    }

    public function checkEmail($attribute,$params)
    {
        $model = User::model()->find('email = :email', array(':email' => $this->$attribute));
        
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