<?php
class FeedBackForm extends CFormModel
{
    public $name;
    public $email;
    public $theme;
    public $text;
    public $type;
    public $verifyCode;

    public function rules()
    {
        return array(
            array('name, email, theme, text', 'required'),
            array('type', 'numerical', 'integerOnly' => true),
            array('name, email', 'length', 'max' => 100),
            array('theme', 'length', 'max' => 150),
            array('email', 'email'),
            array('verifyCode', 'YRequiredValidator', 'allowEmpty' => !Yii::app()->getModule('feedback')->showCaptcha),
            array('verifyCode', 'captcha', 'allowEmpty' => !Yii::app()->getModule('feedback')->showCaptcha)
        );
    }

    public function attributeLabels()
    {
        return array(
            'name' => Yii::t('feedback','Ваше имя'),
            'email' => Yii::t('feedback','Email'),
            'theme' => Yii::t('feedback','Тема'),
            'text' => Yii::t('feedback','Текст'),
            'verifyCode' => Yii::t('feedback','Код проверки'),
            'type' => Yii::t('feedback','Тип')
        );
    }
}