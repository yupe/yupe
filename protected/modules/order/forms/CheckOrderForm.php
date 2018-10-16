<?php
/**
 * Class CheckOrderForm
 */
class CheckOrderForm extends CFormModel
{
    /**
     * @var
     */
    public $number;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            ['number', 'required'],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'number' =>  Yii::t('OrderModule.order', 'Order #'),
        ];
    }
} 
