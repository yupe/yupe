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
            array('name, email, phone', 'length', 'max' => 150),
            array('theme', 'length', 'max' => 250),
            array('email', 'email'),
            array('verifyCode', 'YRequiredValidator', 'allowEmpty' => !$module->showCaptcha || Yii::app()->user->isAuthenticated()),
            array('verifyCode', 'captcha', 'allowEmpty' => !$module->showCaptcha || Yii::app()->user->isAuthenticated()),
        );
    }

    public function attributeLabels()
    {
        return array(
            'name'       => Yii::t('FeedbackModule.feedback', 'Ваше имя'),
            'email'      => Yii::t('FeedbackModule.feedback', 'Email'),
            'phone'      => Yii::t('FeedbackModule.feedback', 'Телефон'),
            'theme'      => Yii::t('FeedbackModule.feedback', 'Тема'),
            'text'       => Yii::t('FeedbackModule.feedback', 'Текст'),
            'verifyCode' => Yii::t('FeedbackModule.feedback', 'Код проверки'),
            'type'       => Yii::t('FeedbackModule.feedback', 'Тип'),
        );
    }
}