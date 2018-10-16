<?php

namespace yupe\widgets;

use CException;

/**
 * Class RandomDataWidget
 * @package yupe\widgets
 */
class RandomDataWidget extends YWidget
{
    /**
     * @var
     */
    public $data;

    /**
     * @throws CException
     */
    public function init()
    {
        if (!is_array($this->data) || empty($this->data)) {
            throw new CException("'RandomDataWidget' empty data!");
        }
    }

    /**
     * @throws CException
     */
    public function run()
    {
        $this->render('randomdata', ['item' => $this->data[array_rand($this->data)]]);
    }
}
