<?php
class ProducerFilterWidget extends \yupe\widgets\YWidget
{
    public $view = 'producer-filter';

    public function run()
    {
        $this->render($this->view, ['producers' => Producer::model()->published()->cache($this->cacheTime)->findAll()]);
    }
} 
