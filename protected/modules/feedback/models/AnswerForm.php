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
            array('is_faq', 'in', 'range' => array(0, 1)),
        );
    }

    public function attributeLabels()
    {
        return array(
            'answer' => Yii::t('FeedbackModule.feedback', 'Reply'),
            'is_faq' => Yii::t('FeedbackModule.feedback', 'In FAQ'),
        );
    }
}