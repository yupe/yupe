<?php

/**
 * @author Zmiulan <info@yohanga.biz>
 * @link http://yohanga.biz
 * @copyright 2014 Zmiulan
 *
 */
class PhoneConfirmForm extends CFormModel
{
    public $token;

    public function rules()
    {
        return [
            ['token', 'filter', 'filter' => 'trim'],
            ['token', 'filter', 'filter' => [$obj = new CHtmlPurifier(), 'purify']],
            ['token', 'required'],
            ['token', 'length', 'max' => 50],
            ['token', 'numerical', 'integerOnly' => true],
        ];
    }

    public function attributeLabels()
    {
        return [
            'token' => Yii::t('UserModule.user', 'Verification code'),
        ];
    }

}
