<?php

class StoreImage
{
    /**
     * @param Producer $producer
     * @param int $width
     * @param int $height
     * @param bool|true $crop
     * @return mixed
     */
    public static function producer(Producer $producer, $width = 0, $height = 0, $crop = true)
    {
        return $producer->getImageUrl($width, $height, $crop, static::getDefaultImage());
    }

    /**
     * @param StoreCategory $category
     * @param int $width
     * @param int $height
     * @param bool|true $crop
     * @return mixed
     */
    public static function category(StoreCategory $category, $width = 0, $height = 0, $crop = true)
    {
        return $category->getImageUrl($width, $height, $crop, static::getDefaultImage());
    }

    /**
     * @param Product $product
     * @param int $width
     * @param int $height
     * @param bool|true $crop
     * @return mixed
     */
    public static function product(Product $product, $width = 0, $height = 0, $crop = true)
    {
        return $product->getImageUrl($width, $height, $crop, static::getDefaultImage());
    }

    public static function getDefaultImage()
    {
        /* @var $theme \yupe\components\Theme */
        $theme = Yii::app()->getTheme();
        return $theme->getAssetsUrl() . Yii::app()->getModule('store')->defaultImage;
    }
}