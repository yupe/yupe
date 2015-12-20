<?php

/**
 * Class ProducerFilterWidget
 */
class ProducerFilterWidget extends \yupe\widgets\YWidget
{
    /**
     * @var string
     */
    public $view = 'producer-filter';

    /**
     * @throws CException
     */
    public function run()
    {
        $this->render($this->view, ['producers' => Producer::model()->published()->findAll([
            'limit' => $this->limit
        ])]);
    }
} 
