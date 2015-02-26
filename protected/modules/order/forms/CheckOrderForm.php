<?php

class CheckOrderForm extends CFormModel
{
    public $number;

    public function rules()
    {
        return [
            ['number', 'required'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'number' =>  Yii::t('OrderModule.order', 'Order #'),
        ];
    }
} 
