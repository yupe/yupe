<?php
class RecoveryForm extends CFormModel
{
    public $email;

    private $_user;

    public function rules()
    {
        return array(
            array('email', 'required'),
            array('email', 'email'),
            array('email','checkEmail')
        );
    }

    public function checkEmail($attribute,$params)
    {    	
    	if(!$this->hasErrors())
    	{
    		$this->_user = User::model()->find('email = :email',array(':email' => $this->email));

    		if(!$this->_user)
    		    $this->addError('email',Yii::t('user','Email "{email}" не найден!',array('{email}' => $this->email)));
    	}
    }

    public function getUser()
    {
    	return $this->_user;
    }
}