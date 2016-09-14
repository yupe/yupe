<?php

/**
 * Class OrderHelper
 */
class OrderHelper
{
    /**
     *
     */
    const STATUS_COLOR_BLACK = 'black';
    /**
     *
     */
    const STATUS_COLOR_BLUE = 'primary';
    /**
     *
     */
    const STATUS_COLOR_CYAN = 'info';
    /**
     *
     */
    const STATUS_COLOR_GREEN = 'success';
    /**
     *
     */
    const STATUS_COLOR_GREY = 'default';
    /**
     *
     */
    const STATUS_COLOR_MINT = 'mint';
    /**
     *
     */
    const STATUS_COLOR_ORANGE = 'warning';
    /**
     *
     */
    const STATUS_COLOR_PISTACHIO = 'pistachio';
    /**
     *
     */
    const STATUS_COLOR_PURPLE = 'purple';
    /**
     *
     */
    const STATUS_COLOR_RED = 'danger';
    /**
     *
     */
    const STATUS_COLOR_YELLOW = 'yellow';

    /**
     * @return array
     */
    public static function statusList()
    {
        return CHtml::listData(OrderStatus::model()->findAll(), 'id', 'name');
    }

    /**
     * @return array
     */
    public static function labelList()
    {
        $labels = [];
        $statuses = OrderStatus::model()->findAll();
        
        foreach ($statuses as $status) {
            if ($status->color) {
                $labels[$status->id] = ['class' => 'label-' . $status->color];
            }
        }

        return $labels;
    }

    /**
     * @return array
     */
    public static function colorNames()
    {
        return [
            self::STATUS_COLOR_BLACK => Yii::t('OrderModule.order', 'Black'),
            self::STATUS_COLOR_GREY => Yii::t('OrderModule.order', 'Grey'),
            self::STATUS_COLOR_BLUE => Yii::t('OrderModule.order', 'Blue'),
            self::STATUS_COLOR_CYAN => Yii::t('OrderModule.order', 'Cyan'),
            self::STATUS_COLOR_PURPLE => Yii::t('OrderModule.order', 'Purple'),
            self::STATUS_COLOR_RED => Yii::t('OrderModule.order', 'Red'),
            self::STATUS_COLOR_GREEN => Yii::t('OrderModule.order', 'Green'),
            self::STATUS_COLOR_PISTACHIO => Yii::t('OrderModule.order', 'Pistachio'),
            self::STATUS_COLOR_MINT => Yii::t('OrderModule.order', 'Mint'),
            self::STATUS_COLOR_ORANGE => Yii::t('OrderModule.order', 'Orange'),
            self::STATUS_COLOR_YELLOW => Yii::t('OrderModule.order', 'Yellow'),
        ];
    }

    /**
     * @return array
     */
    public static function colorValues()
    {
        return [
            self::STATUS_COLOR_BLACK => ['data-color' => '#000000'],
            self::STATUS_COLOR_BLUE => ['data-color' => '#428bca'],
            self::STATUS_COLOR_CYAN => ['data-color' => '#5bc0de'],
            self::STATUS_COLOR_GREEN => ['data-color' => '#5cb85c'],
            self::STATUS_COLOR_GREY => ['data-color' => '#999999'],
            self::STATUS_COLOR_MINT => ['data-color' => '#aaf0d1'],
            self::STATUS_COLOR_ORANGE => ['data-color' => '#f0ad4e'],
            self::STATUS_COLOR_PISTACHIO => ['data-color' => '#bef574'],
            self::STATUS_COLOR_PURPLE => ['data-color' => '#800080'],
            self::STATUS_COLOR_RED => ['data-color' => '#d9534f'],
            self::STATUS_COLOR_YELLOW => ['data-color' => '#ffff00'],
        ];
    }
}