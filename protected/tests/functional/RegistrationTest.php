<?php

class RegistrationTest extends WebTestCase
{
    public $fixtures = array(
        'registrations' => 'Registration',
    );

    public function testShow()
    {
        $this->open('?r=registration/view&id=1');
    }

    public function testCreate()
    {
        $this->open('?r=registration/create');
    }

    public function testUpdate()
    {
        $this->open('?r=registration/update&id=1');
    }

    public function testDelete()
    {
        $this->open('?r=registration/view&id=1');
    }

    public function testList()
    {
        $this->open('?r=registration/index');
    }

    public function testAdmin()
    {
        $this->open('?r=registration/admin');
    }
}
