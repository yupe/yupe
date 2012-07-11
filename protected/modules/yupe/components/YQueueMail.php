<?php
class YQueueMail extends YMail
{
	public function init()
	{
		parent::init();
	}

	public function send($from, $to, $theme, $body, $isText = false)
	{
		return Yii::app()->queue->add(1,array(
			'from'  => $from,
			'to'    => $to,
			'theme' => $theme,
			'body'  => $body
		));
	}
}