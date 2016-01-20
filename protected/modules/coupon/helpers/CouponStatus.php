<?php

class CouponStatus
{
    const STATUS_NOT_ACTIVE = 0;
    const STATUS_ACTIVE = 1;

    /**
     * Return key=>value statuses list
     *
     * @return array
     */
    public static function all()
    {
        return [
            self::STATUS_ACTIVE => Yii::t('CouponModule.coupon', 'Active'),
            self::STATUS_NOT_ACTIVE => Yii::t('CouponModule.coupon', 'Not active'),
        ];
    }

    /**
     * Return statuses keys
     *
     * @return array
     */
    public static function keys()
    {
        return array_keys(self::all());
    }

    /**
     * Return CSS class names associated with status
     *
     * @return array
     */
    public static function colors()
    {
        return [
            self::STATUS_ACTIVE => ['class' => 'label label-success'],
            self::STATUS_NOT_ACTIVE => ['class' => 'label label-default'],
        ];
    }

    /**
     * Return status title
     *
     * @param int $id Status ID
     * @return string
     */
    public static function title($id)
    {
        $data = self::all();

        return isset($data[$id]) ? $data[$id] : Yii::t('CouponModule.coupon', '*unknown*');
    }

    /**
     * Return status colored label
     *
     * @param int $id Status ID
     * @return string
     */
    public static function coloredLabel($id)
    {
        $colors = self::colors();

        return CHtml::tag('span', $colors[$id], self::title($id));
    }
}