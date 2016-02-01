<?php
namespace yupe\helpers;

use Yii;

/**
 * Class Url
 * @package yupe\helpers
 */
class Url
{
    /**
     * @param $url
     * @return string
     */
    public static function redirectUrl($url)
    {
        $baseUrl = Yii::app()->getBaseUrl();
        if (strpos($url, ':') || (!empty($baseUrl) && strpos($url, Yii::app()->getBaseUrl()) !== false)) {
            return $url;
        }

        return Yii::app()->createAbsoluteUrl($url);
    }
}
