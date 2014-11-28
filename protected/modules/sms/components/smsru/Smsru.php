<?php

/**
 * @author Zmiulan <info@yohanga.biz>
 * @link http://yohanga.biz
 * @copyright 2014 Zmiulan
 *
 */
class Smsru extends CApplicationComponent
{
	private $sms;
	public $api_id;
	public $login;
	public $password;

	public function init()
	{
		require_once dirname( __FILE__ ) . '/Zelenin/smsru.php';
        $this->api_id=Yii::app()->getModule('sms')->api_id;
		if ( !empty( $this->login ) && !empty( $this->password ) ) {
			$this->sms = new \Zelenin\smsru( $this->api_id, $this->login, $this->password );
		} else {
			$this->sms = new \Zelenin\smsru( $this->api_id );
		}
        $this->sms->setSender(Yii::app()->getModule('sms')->sender);
		parent::init();
	}

	public function __call( $name, $parameters )
	{
		if ( method_exists( $this->sms, $name ) ) {
			return call_user_func_array( [ $this->sms, $name ], $parameters );
		} else {
			return call_user_func_array( [ $this, $name ], $parameters );
		}
	}
}
