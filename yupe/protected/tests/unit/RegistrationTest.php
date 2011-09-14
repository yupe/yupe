<?php

class RegistrationTest extends CDbTestCase
{
	public $fixtures = array(
		'registrations' => 'Registration',
	);
	
	private $registration;

        public function setUp()
	{
		$this->registration = new Registration();
	}
	
	// проверить добавление новой записи
	//  - повторное добавление того же email
	//  - повторное добавление того же nickName
	//  - повторное добавление того же code
	public function testCreate()
	{
		
	}

	// проверить генерацию кода активации пользователя
	public function testGenerateActivationCode()
	{		
		$code = $this->registration->generateActivationCode('test@mail.ru');
		$this->assertEquals(32,mb_strlen($code));
	}
	
	// проверить генерацию соли для пароля
	public function testGenerateSalt()
	{
		$salt = $this->registration->generateSalt();
		$this->assertEquals(32,mb_strlen($salt));
	}
	
	// проверка генерации пароля
	public function testGeneratePassword()
	{
		$password = $this->registration->generatePassword();
		$this->assertEquals(6,strlen($password));
		$password = $this->registration->generatePassword(10);
		$this->assertEquals(10,strlen($password));
	}
	
	
	public function testHashPassword()
	{
		$password     = '123456';
		$salt = $this->registration->generateSalt();
		$passwordHash   = md5($password.$salt);
		$hashedPassword = $this->registration->hashPassword($password,$salt);
		$this->assertEquals($passwordHash,$hashedPassword);		
	}
	
}