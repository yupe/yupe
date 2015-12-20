<?php

class StoreImage
{
    public static function producer(Producer $producer, $width = null, $height = null)
    {
        $image = $producer->getImageUrl($width, $height);

        return $image ? $image : Yii::app()->getTheme()->getAssetsUrl().Yii::app()->getModule('store')->defaultImage;
    }

    public static function category(StoreCategory $category, $width = null, $height = null)
    {
        $image = $category->getImageUrl($width, $height);

        return $image ? $image : Yii::app()->getTheme()->getAssetsUrl().Yii::app()->getModule('store')->defaultImage;
    }

    public static function product(Product $product, $width = null, $height = null)
    {
        $image = $product->getImageUrl($width, $height);

        return $image ? $image : Yii::app()->getTheme()->getAssetsUrl().Yii::app()->getModule('store')->defaultImage;
    }
}