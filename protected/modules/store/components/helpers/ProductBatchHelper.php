<?php

/**
 * Class ProductBatchHelper
 */
class ProductBatchHelper
{
    /**
     *
     */
    const PRICE_EQUAL = 0;

    /**
     *
     */
    const PRICE_ADD = 1;

    /**
     *
     */
    const PRICE_SUB = 2;

    /**
     *
     */
    const OP_UNIT = 0;

    /**
     *
     */
    const OP_PERCENT = 1;

    /**
     * @return array
     */
    public static function getPericeOpList()
    {
        return [
            self::PRICE_EQUAL => Yii::t('StoreModule.store', 'equal'),
            self::PRICE_ADD => Yii::t('StoreModule.store', 'increase'),
            self::PRICE_SUB => Yii::t('StoreModule.store', 'decrease'),
        ];
    }

    /**
     * @return array
     */
    public static function getOpUnits()
    {
        return [
            self::OP_UNIT => Yii::t('StoreModule.store', 'unit'),
            self::OP_PERCENT => Yii::t('StoreModule.store', '%'),
        ];
    }
}