<?php

class YFlashMessages extends YWidget
{
    const SUCCESS_MESSAGE = 'success';
    const INFO_MESSAGE = 'info';
    const WARNING_MESSAGE = 'warning';
    const ERROR_MESSAGE = 'error';

    public $options = array();

    public function run()
    {
        $this->render('flashmessages', array('options' => $this->options));
    }
}