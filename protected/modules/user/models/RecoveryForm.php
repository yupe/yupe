<?php
class RecoveryForm extends CFormModel
{
    public $email;

    public function rules()
    {
        return array(
            array('email', 'required'),
            array('email', 'email')
        );
    }
}

?>
