<?php

class FeedBackTest extends WebTestCase
{
	public $fixtures=array(
		'feedBacks'=>'FeedBack',
	);

	public function testShow()
	{
		$this->open('?r=feedBack/view&id=1');
	}

	public function testCreate()
	{
		$this->open('?r=feedBack/create');
	}

	public function testUpdate()
	{
		$this->open('?r=feedBack/update&id=1');
	}

	public function testDelete()
	{
		$this->open('?r=feedBack/view&id=1');
	}

	public function testList()
	{
		$this->open('?r=feedBack/index');
	}

	public function testAdmin()
	{
		$this->open('?r=feedBack/admin');
	}
}
