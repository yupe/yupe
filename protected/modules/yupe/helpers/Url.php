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
        if (strpos($url, ':') || (!empty(Yii::app()->getBaseUrl()) && strpos($url, Yii::app()->getBaseUrl()) !== false)) {
            return $url;
        }

        return Yii::app()->createAbsoluteUrl($url);
    }
}
