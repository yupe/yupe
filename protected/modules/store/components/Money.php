<?php

/**
 * Class Money - заглушка для конвертора валют
 */
class Money extends CApplicationComponent
{
    /**
     * @param $sum
     * @param $currencyId
     * @return mixed
     */
    public function convert($sum, $currencyId)
    {
        return $sum;
    }
}