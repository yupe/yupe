<?php
namespace yupe\helpers;

use Yii;

class Url {

	public static function redirectUrl($url)
	{
		if (strpos($url, ':') || strpos($url, Yii::app()->baseUrl) !== false) {
			return $url;
		}

		return Yii::app()->createAbsoluteUrl($url);
	}
} 