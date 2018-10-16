<?php

class QFilterWidget extends \yupe\widgets\YWidget
{
    public $view = 'q-filter';

    public function run()
    {
        $this->render($this->view);
    }
}