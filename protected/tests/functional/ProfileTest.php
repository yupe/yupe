<?php

class ProfileTest extends WebTestCase
{
	public $fixtures=array(
		'profiles'=>'Profile',
	);

	public function testShow()
	{
		$this->open('?r=profile/view&id=1');
	}

	public function testCreate()
	{
		$this->open('?r=profile/create');
	}

	public function testUpdate()
	{
		$this->open('?r=profile/update&id=1');
	}

	public function testDelete()
	{
		$this->open('?r=profile/view&id=1');
	}

	public function testList()
	{
		$this->open('?r=profile/index');
	}

	public function testAdmin()
	{
		$this->open('?r=profile/admin');
	}
}
