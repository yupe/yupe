<?php
/**
 * Created by JetBrains PhpStorm.
 * User: andrey
 * Date: 11/5/13
 * Time: 7:14 PM
 * To change this template use File | Settings | File Templates.
 *
 *
 * @group user
 *
 */

class RegistrationFormTest extends \Codeception\TestCase\Test
{
    protected $form;

    public function _before()
    {
        $this->form = new \RegistrationForm();
    }

    public function testWrongData()
    {
        $this->form->setAttributes(array());

        $this->assertFalse($this->form->validate());
    }
}