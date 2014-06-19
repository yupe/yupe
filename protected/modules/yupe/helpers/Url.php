<?php
namespace yupe\helpers;

use Yii;

class Url {

    public static function redirectUrl($url)
    {
        if(strpos($url,':')) {
            return $url;
        }


        return Yii::app()->createAbsoluteUrl($url);
    }
} 