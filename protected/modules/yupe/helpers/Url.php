<?php
namespace yupe\helpers;

use Yii;

class Url {

	public static function redirectUrl($url)
	{
		if (strpos($url, ':') || strpos(Yii::app()->baseUrl, $url) !== false) {
			return $url;
		}

		return Yii::app()->createAbsoluteUrl($url);
	}
} 