<?php

/**
 * Class Money - заглушка для конвертора валют
 */
class Money extends CComponent
{
    public function init()
    {

    }

    public function convert($sum, $currencyId)
    {
        return $sum;
    }
}