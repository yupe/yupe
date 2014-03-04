<?php 

namespace yupe\widgets;
use CException;

class RandomDataWidget extends YWidget
{
	public $data;

	public function init()
	{
		if(!is_array($this->data) || empty($this->data)) {
			throw new CException("'RandomDataWidget' empty data!");			
		}
	}

	public function run()
    {    	
        $this->render('randomdata', array('item' => $this->data[array_rand($this->data)]));
    }
}