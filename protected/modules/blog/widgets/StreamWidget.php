<?php

class StreamWidget extends yupe\widgets\YWidget
{
    public $view = 'stream';

    public $limit = 10;

    public function run()
    {
        $this->render($this->view, ['data' => Post::model()->getStream($this->limit, $this->cacheTime)]);
    }
}
