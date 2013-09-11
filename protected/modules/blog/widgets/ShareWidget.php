<?php
class ShareWidget extends YWidget
{
    public $view = 'share';

    public function run()
    {
        $this->render($this->view);
    }
}