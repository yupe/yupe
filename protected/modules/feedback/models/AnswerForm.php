<?php
class AnswerForm extends CFormModel
{
	public $answer;

	public $isFaq;

	public $email;

	public function rules()
	{
		return array(
			array('answer','required'),			
			array('isFaq','in','range' => array(0,1))
		);
	}

	public function attributeLabels()
	{
		return array(
			'answer' => Yii::t('feedback','Ответ'),
			'isFaq'  => Yii::t('feedback','Добавить в faq')
		);
	}
}
?>