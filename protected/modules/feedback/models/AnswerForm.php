<?php
class AnswerForm extends CFormModel
{
    public $answer;

    public $is_faq;

    public $email;

    public function rules()
    {
        return array(
            array('answer', 'required'),
            array('is_faq', 'in', 'range' => array(0, 1))
        );
    }

    public function attributeLabels()
    {
        return array(
            'answer' => Yii::t('feedback', 'Ответ'),
            'is_faq' => Yii::t('feedback', 'Добавить в faq')
        );
    }
}