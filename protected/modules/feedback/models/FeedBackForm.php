<?php

/**
 * FeedBackForm форма обратной связи для публичной части сайта
 *
 * @category YupeController
 * @package  yupe.modules.feedback.models
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @link     http://yupe.ru
 *
 **/

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
            array('verifyCode', 'yupe\components\validators\YRequiredValidator', 'allowEmpty' => !$module->showCaptcha || Yii::app()->user->isAuthenticated()),
            array('verifyCode', 'captcha', 'allowEmpty' => !$module->showCaptcha || Yii::app()->user->isAuthenticated()),
        );
    }

    public function attributeLabels()
    {
        return array(
            'name'       => Yii::t('FeedbackModule.feedback', 'Your name'),
            'email'      => Yii::t('FeedbackModule.feedback', 'Email'),
            'phone'      => Yii::t('FeedbackModule.feedback', 'Phone'),
            'theme'      => Yii::t('FeedbackModule.feedback', 'Topic'),
            'text'       => Yii::t('FeedbackModule.feedback', 'Text'),
            'verifyCode' => Yii::t('FeedbackModule.feedback', 'Check code'),
            'type'       => Yii::t('FeedbackModule.feedback', 'Type'),
        );
    }
}