<?php
class FeedBackForm extends CFormModel
{
    public $name;
    public $email;
    public $phone;
    public $theme;
    public $text;
    public $type;
    public $verifyCode;

    public function rules()
    {
        $module = Yii::app()->getModule('feedback');
        return array(
            array('name, email, theme, text', 'required'),
            array('type', 'numerical', 'integerOnly' => true),
            array('name, email, phone', 'length', 'max' => 100),
            array('theme', 'length', 'max' => 150),
            array('email', 'email'),
            array('verifyCode', 'YRequiredValidator', 'allowEmpty' => !$module->showCaptcha || Yii::app()->user->isAuthenticated()),
            array('verifyCode', 'captcha', 'allowEmpty' => !$module->showCaptcha || Yii::app()->user->isAuthenticated())
        );
    }

    public function attributeLabels()
    {
        return array(
            'name' => Yii::t('feedback','Ваше имя'),
            'email' => Yii::t('feedback','Email'),
            'phone' => Yii::t('feedback','Телефон'),
            'theme' => Yii::t('feedback','Тема'),
            'text' => Yii::t('feedback','Текст'),
            'verifyCode' => Yii::t('feedback','Код проверки'),
            'type' => Yii::t('feedback','Тип')
        );
    }
}