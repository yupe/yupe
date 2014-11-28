<?php

/**
 * @author Zmiulan <info@yohanga.biz>
 * @link http://yohanga.biz
 * @copyright 2014 Zmiulan
 *
 */
class ProfilePhoneForm extends CFormModel
{
    public $phone;

    public function rules()
    {
        return [
            ['phone', 'filter', 'filter' => 'trim'],
            ['phone', 'filter', 'filter' => [$obj = new CHtmlPurifier(), 'purify']],
            ['phone', 'required'],
            ['phone', 'length', 'max' => 50],
            [
                'phone',
                'match',
                'pattern' => '/^\+?[0-9]{10,50}$/',
                'message' => Yii::t(
                        'UserModule.user',
                        'Bad field format for "{attribute}". Phone number must be in international format +(country code)(phone number)'
                    )
            ],
            ['phone', 'checkPhone'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'phone' => Yii::t('UserModule.user', 'Phone'),
        ];
    }

    public function checkPhone($attribute, $params)
    {
        if (Yii::app()->user->profile->phone != $this->$attribute) {
            $model = User::model()->find('phone = :phone', [':phone' => $this->$attribute]);
            if ($model) {
                $this->addError('phone', Yii::t('UserModule.user', 'Phone already busy'));
            }
        }
    }
}
