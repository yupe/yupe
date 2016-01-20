<?php
class CouponType
{
    const TYPE_SUM = 0;
    const TYPE_PERCENT = 1;

    /**
     * Return key=>value types list
     *
     * @return array
     */
    public static function all()
    {
        return [
            self::TYPE_SUM => Yii::t('CouponModule.coupon', 'Sum'),
            self::TYPE_PERCENT => Yii::t('CouponModule.coupon', 'Percent'),
        ];
    }

    /**
     * Return types keys
     *
     * @return array
     */
    public static function keys()
    {
        return array_keys(self::all());
    }

    /**
     * Return type title
     *
     * @param int $id Type ID
     * @return string
     */
    public static function title($id)
    {
        $data = self::all();

        return isset($data[$id]) ? $data[$id] : Yii::t('CouponModule.coupon', '*unknown*');
    }
}