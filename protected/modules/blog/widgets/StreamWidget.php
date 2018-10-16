<?php

/**
 * Class StreamWidget
 */
class StreamWidget extends yupe\widgets\YWidget
{
    /**
     * @var string
     */
    public $view = 'stream';

    /**
     * @var int
     */
    public $limit = 10;

    /**
     * @throws CException
     */
    public function run()
    {
        $this->render($this->view, ['data' => Post::model()->getStream($this->limit, $this->cacheTime)]);
    }
}
