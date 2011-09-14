<?php

class RecoveryPasswordTest extends WebTestCase
{
	public $fixtures=array(
		'recoveryPasswords'=>'RecoveryPassword',
	);

	public function testShow()
	{
		$this->open('?r=recoveryPassword/view&id=1');
	}

	public function testCreate()
	{
		$this->open('?r=recoveryPassword/create');
	}

	public function testUpdate()
	{
		$this->open('?r=recoveryPassword/update&id=1');
	}

	public function testDelete()
	{
		$this->open('?r=recoveryPassword/view&id=1');
	}

	public function testList()
	{
		$this->open('?r=recoveryPassword/index');
	}

	public function testAdmin()
	{
		$this->open('?r=recoveryPassword/admin');
	}
}
